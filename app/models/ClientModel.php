<?php
// Modèle pour gérer les clients dans la base de données
class ClientModel {
    private PDO $db;

    // Connexion automatique à la base de données
    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Récupère la liste de tous les clients (triée par nom)
    public function getALL(): array {
    	$stmt = $this->db->query('SELECT * FROM clients ORDER BY nom_prenoms');
    	return $stmt->fetchALL();
    }

    // Récupère un seul client grâce à son ID
    public function getById(int $id): ?array{
    	$stmt = $this->db->prepare('SELECT * FROM clients WHERE id = ?');
    	$stmt->execute([$id]);
    	return $stmt->fetch() ?: null;
    }

    // Ajoute un nouveau client avec ses infos
    public function create(array $data): bool{
    	$stmt = $this->db->prepare('INSERT INTO clients(nom_prenoms, telephone, situation_geo, ville, mode_retrait, frais_livraison, email) VALUES(?,?,?,?,?,?,?)');
    	return $stmt->execute([
              $data['nom_prenoms'],
              $data['telephone'],
              $data['situation_geo'],
              $data['ville'],
              $data['mode_retrait'],
              $data['frais_livraison'],
              $data['email'],
    	]);
    }

    // Modifie les infos d'un client existant via son ID
    public function update(int $id, array $data): bool{
    	$stmt = $this->db->prepare('UPDATE clients SET nom_prenoms = ?, telephone = ?, situation_geo = ?, ville = ?, mode_retrait = ?, frais_livraison = ?, email = ? WHERE id = ?');
    	return $stmt->execute([
              $data['nom_prenoms'],
              $data['telephone'],
              $data['situation_geo'],
              $data['ville'],
              $data['mode_retrait'],
              $data['frais_livraison'],
              $data['email'],
              $id
    	]);
    }

    // Supprime définitivement un client via son ID
    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM clients WHERE id = ?');
        return $stmt->execute([$id]);
    }

}