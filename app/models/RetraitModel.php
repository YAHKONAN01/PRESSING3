<?php
class RetraitModel {
    private PDO $db;

    public function __construct() {
        // Connexion à la base de données via votre Singleton
        $this->db = Database::getInstance();
    }

    /**
     * Récupère la liste de tous les dépôts ayant du linge emballé
     * pour alimenter le tableau du haut.
     */
    public function getDepotsPrets(): array {
        $stmt = $this->db->query("
            SELECT DISTINCT 
                d.id, 
                d.client_nom, 
                d.client_telephone, 
                d.date_depot, 
                d.code_depot, 
                d.reste_a_payer, 
                d.date_retrait, 
                d.mode_retrait
            FROM depots d
            JOIN depot_lignes dl ON d.id = dl.depot_id
            WHERE dl.statut_traitement = 'emballe'
            ORDER BY d.date_depot DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche un dépôt prêt pour le retrait via son Code OU son Numéro de Téléphone
     * (Vérifie qu'il y a bien des articles emballés et non encore livrés)
     */
    public function getDepotPourRetrait(string $recherche): ?array {
        $stmt = $this->db->prepare("
            SELECT DISTINCT d.* FROM depots d
            JOIN depot_lignes dl ON d.id = dl.depot_id
            WHERE (d.code_depot = ? OR d.client_telephone = ?)
              AND dl.statut_traitement = 'emballe'
            LIMIT 1
        ");
        $stmt->execute([$recherche, $recherche]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Récupère la liste de tous les vêtements associés à un dépôt
     */
    public function getLignesDepot(int $depotId): array {
        $stmt = $this->db->prepare("
            SELECT * FROM depot_lignes 
            WHERE depot_id = ?
            ORDER BY id ASC
        ");
        $stmt->execute([$depotId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Enregistre un nouveau retrait dans la table des retraits.
     *
     * @param array $data Données du retrait (depot_id, type_operation, etc.)
     * @return bool True en cas de succès, false sinon.
     */
    public function enregistrerRetrait(array $data): bool {
        $stmt = $this->db->prepare("
            INSERT INTO retraits (
                depot_id, type_operation, montant_a_payer,
                montant_paye, mode_reglement, 
                reference_paiement, retire_par, date_retrait
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['depot_id'],
            $data['type_operation'],
            $data['montant_a_payer'],
            $data['montant_paye'],
            $data['mode_reglement'],
            $data['reference_paiement'],
            $data['retire_par'],
            $data['date_retrait'],
        ]);
    }

    /**
     * Finalise le retrait : encaisse le solde, recalcule le reste à payer,
     * et passe les articles et le dépôt à l'état 'livre' de manière sécurisée.
     */
    public function finaliserRetrait(int $depotId, int $montantSaisi): bool {
        try {
            // Début de la transaction pour sécuriser la double mise à jour
            $this->db->beginTransaction();

            // 1. Récupération de la situation financière actuelle du dépôt
            $stmt = $this->db->prepare("SELECT net_a_payer, montant_paye FROM depots WHERE id = ?");
            $stmt->execute([$depotId]);
            $depot = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$depot) {
                $this->db->rollBack();
                return false;
            }

            // 2. Calcul des nouveaux montants
            $nouveauMontantPaye = $depot['montant_paye'] + $montantSaisi;
            $nouveauReste = max(0, $depot['net_a_payer'] - $nouveauMontantPaye);

            // 3. Mise à jour de la table principale 'depots'
            $stmtUpdateDepot = $this->db->prepare("
                UPDATE depots 
                SET montant_paye = ?, 
                    reste_a_payer = ?, 
                    statut = 'livre' 
                WHERE id = ?
            ");
            $stmtUpdateDepot->execute([$nouveauMontantPaye, $nouveauReste, $depotId]);

            // 4. Clôture des lignes d'articles : passage de 'emballe' à 'livre'
            $stmtUpdateLignes = $this->db->prepare("
                UPDATE depot_lignes 
                SET statut_traitement = 'livre' 
                WHERE depot_id = ? AND statut_traitement = 'emballe'
            ");
            $stmtUpdateLignes->execute([$depotId]);

            // Validation de toutes les opérations si aucune erreur
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // En cas de problème ou d'erreur SQL, on annule tout
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }
}