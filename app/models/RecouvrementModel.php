<?php
class RecouvrementModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Liste des dépôts impayés, avec filtres optionnels (dates + client)
     */
    public function getImpayes(?string $debut = null, ?string $fin = null, ?int $clientId = null): array {
        $sql = "SELECT * FROM depots WHERE reste_a_payer > 0";
        $params = [];

        if ($debut) {
            $sql .= " AND date_depot >= ?";
            $params[] = $debut;
        }
        if ($fin) {
            $sql .= " AND date_depot <= ?";
            $params[] = $fin;
        }
        if ($clientId) {
            $sql .= " AND client_id = ?";
            $params[] = $clientId;
        }

        $sql .= " ORDER BY date_depot DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Liste de tous les clients (pour le menu déroulant de filtre)
     */
    public function getClients(): array {
        return $this->db->query('SELECT id, nom_prenoms FROM clients ORDER BY nom_prenoms')->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un dépôt précis par son ID
     */
    public function getDepotById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM depots WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Récupère les articles (vêtements) liés à un dépôt
     */
    public function getLignesByDepot(int $depotId): array {
        $stmt = $this->db->prepare('SELECT * FROM depot_lignes WHERE depot_id = ?');
        $stmt->execute([$depotId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Enregistre un paiement + option retrait
     * $type peut valoir : 'paiement', 'retrait', 'les_deux'
     */
    public function payer(int $depotId, float $montant, string $modeReglement, string $reference, string $type): bool {
        $depot = $this->getDepotById($depotId);
        if (!$depot) {
            return false;
        }

        // Sécurité : ne pas payer plus que le reste dû
        if ($montant > $depot['reste_a_payer']) {
            $montant = $depot['reste_a_payer'];
        }

        $this->db->beginTransaction();

        try {
            // 1. Mise à jour du dépôt (montant payé)
            if ($montant > 0) {
                $nouveauMontantPaye = $depot['montant_paye'] + $montant;
                $nouveauReste = $depot['reste_a_payer'] - $montant;

                $stmt = $this->db->prepare('
                    UPDATE depots 
                    SET montant_paye = ?, reste_a_payer = ?, mode_reglement = ?, reference_paiement = ? 
                    WHERE id = ?
                ');
                $stmt->execute([$nouveauMontantPaye, $nouveauReste, $modeReglement, $reference, $depotId]);

                // 2. Créer l'entrée correspondante dans le Journal de caisse
                $caisse = $this->db->prepare('
                    INSERT INTO operateur_caisse (libelle, motif, montant, sens, date_op) 
                    VALUES (?, ?, ?, ?, ?)
                ');
                $caisse->execute([
                    'Recouvrement - ' . $depot['client_nom'],
                    'Paiement dépôt N°' . $depot['code_depot'],
                    $montant,
                    'entree',
                    date('Y-m-d')
                ]);
            }

            // 3. Si "retrait" ou "les_deux" : on marque le dépôt comme livré
            if ($type === 'retrait' || $type === 'les_deux') {
                $stmtRetrait = $this->db->prepare('
                    UPDATE depots 
                    SET statut = ?, date_retrait = ?, heure_retrait = ? 
                    WHERE id = ?
                ');
                $stmtRetrait->execute(['livre', date('Y-m-d'), date('H:i:s'), $depotId]);
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}