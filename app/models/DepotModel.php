<?php
class DepotModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Récupérer tous les types de vêtements pour le menu déroulant
    public function getTypesVetement(): array {
        $stmt = $this->db->query('SELECT * FROM types_vetement ORDER BY libelle ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function genererCode(): string {
        do {
            $code = date('ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM depots WHERE code_depot = ?');
            $stmt->execute([$code]);
            $existe = $stmt->fetchColumn() > 0;
        } while ($existe);

        return $code;
    }

    public function create(array $data): string {
        $code = $this->genererCode();
        
        $stmt = $this->db->prepare('
            INSERT INTO depots (
                code_depot, client_nom, client_telephone, 
                client_residence, mode_retrait,
                montant_total, reduction, net_a_payer, 
                montant_paye, reste_a_payer,
                date_depot, date_retrait, heure_retrait
            ) VALUES (
                ?, ?, ?,
                ?, ?,
                ?, ?, ?,
                ?, ?,
                ?, ?, ?
            )
        ');

        $stmt->execute([
            $code,
            $data['client_nom'] ?? null,
            $data['client_telephone'] ?? null,
            $data['client_residence'] ?? null,
            $data['mode_retrait'] ?? null,
            $data['montant_total'] ?? 0,
            $data['reduction'] ?? 0,
            $data['net_a_payer'] ?? 0,
            $data['montant_paye'] ?? 0,
            $data['reste_a_payer'] ?? 0,
            $data['date_depot'] ?? null,
            $data['date_retrait'] ?? null,
            $data['heure_retrait'] ?? null,
        ]);

        return $code; 
    }

    public function addLigne(int $depotId, array $data): bool {
        $stmt = $this->db->prepare('
            INSERT INTO depot_lignes (
                depot_id, designation, description,
                service, observation,
                tarif, quantite, montant
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');
        return $stmt->execute([
            $depotId,
            $data['designation'] ?? null,
            $data['description'] ?? null,
            $data['service'] ?? null,
            $data['observation'] ?? null,
            $data['tarif'] ?? 0,
            $data['quantite'] ?? 1,
            $data['montant'] ?? 0,
        ]);
    }

    public function getAll(): array {
        $stmt = $this->db->query('SELECT * FROM depots ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLignes(int $depotId): array {
        $stmt = $this->db->prepare('SELECT * FROM depot_lignes WHERE depot_id = ?');
        $stmt->execute([$depotId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdByCode(string $code): int {
        $stmt = $this->db->prepare('SELECT id FROM depots WHERE code_depot = ?');
        $stmt->execute([$code]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['id'] : 0;
    }

    public function getByCode(string $code): ?array {
        $stmt = $this->db->prepare('SELECT * FROM depots WHERE code_depot = ?');
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getLignesParStatut(string $statut): array {
        $stmt = $this->db->prepare('
            SELECT dl.*, d.code_depot, d.client_nom, d.client_telephone, d.date_depot
            FROM depot_lignes dl
            JOIN depots d ON dl.depot_id = d.id
            WHERE dl.statut_traitement = ?
            ORDER BY d.date_depot, dl.id
        ');
        $stmt->execute([$statut]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatutLigne(int $ligneId, string $statut): bool {
        $stmt = $this->db->prepare('
            UPDATE depot_lignes SET statut_traitement = ? WHERE id = ?
        ');
        return $stmt->execute([$statut, $ligneId]);
    }
}