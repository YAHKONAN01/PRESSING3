<?php
// app/models/CaisseModel.php

class CaisseModel {
    private PDO $db;

    public function __construct() {
        // Récupération de l'instance unique de connexion PDO
        $this->db = Database::getInstance();
    }

    /**
     * Récupère toutes les opérations de caisse (avec filtre par dates optionnel)
     */
    public function getOperations(?string $debut = null, ?string $fin = null): array {
        $sql = "SELECT id, libelle, motif, montant, sens, date_op, created_at 
                FROM operateur_caisse";
        $params = [];

        // Application dynamique des filtres de dates
        if ($debut && $fin) {
            $sql .= " WHERE DATE(date_op) BETWEEN ? AND ?";
            $params = [$debut, $fin];
        } elseif ($debut) {
            $sql .= " WHERE DATE(date_op) >= ?";
            $params = [$debut];
        } elseif ($fin) {
            $sql .= " WHERE DATE(date_op) <= ?";
            $params = [$fin];
        }

        // Tri par date d'opération puis par ID (les plus récentes en premier)
        $sql .= " ORDER BY date_op DESC, id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un mouvement d'entrée ou de sortie dans la table de caisse
     */
    public function create(array $data): bool {
        $stmt = $this->db->prepare('
            INSERT INTO operateur_caisse (libelle, motif, montant, sens, date_op) 
            VALUES (?, ?, ?, ?, ?)
        ');
        
        return $stmt->execute([
            $data['libelle'], 
            $data['motif'], 
            $data['montant'], 
            $data['sens'], 
            $data['date_op']
        ]);
    }

    /**
     * Calcule la balance (total entrées, total sorties et le solde net)
     */
    public function getBalance(?string $debut = null, ?string $fin = null): array {
        $sql = "SELECT 
                    SUM(CASE WHEN sens = 'entree' THEN montant ELSE 0 END) as total_entrees,
                    SUM(CASE WHEN sens = 'sortie' THEN montant ELSE 0 END) as total_sorties
                FROM operateur_caisse";
        $params = [];

        if ($debut && $fin) {
            $sql .= " WHERE DATE(date_op) BETWEEN ? AND ?";
            $params = [$debut, $fin];
        } elseif ($debut) {
            $sql .= " WHERE DATE(date_op) >= ?";
            $params = [$debut];
        } elseif ($fin) {
            $sql .= " WHERE DATE(date_op) <= ?";
            $params = [$fin];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si la table est vide ou s'il n'y a pas de données, on force un float à 0 pour éviter le NULL
        $entrees = floatval($result['total_entrees'] ?? 0);
        $sorties = floatval($result['total_sorties'] ?? 0);
        $solde = $entrees - $sorties;

        return [
            'entrees' => $entrees,
            'sorties' => $sorties,
            'solde'   => $solde
        ];
    }
}