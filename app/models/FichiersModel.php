<?php
class TypeVetementModel {
    private PDO $db;
    public function __construct() {
        $this->db = Database::getInstance();
    }
    public function getAll(): array {
        return $this->db->query('SELECT * FROM types_vetement ORDER BY libelle')->fetchAll();
    }
    public function create(array $data): bool {
        $stmt = $this->db->prepare('INSERT INTO types_vetement (libelle, tarif, description, pack) VALUES(?,?,?,?)');
        return $stmt->execute([$data['libelle'], $data['tarif'], $data['description'], $data['pack']]);
    }
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare('UPDATE types_vetement SET libelle=?, tarif=?, description=?, pack=? WHERE id=?');
        return $stmt->execute([$data['libelle'], $data['tarif'], $data['description'], $data['pack'], $id]);
    }
    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM types_vetement WHERE id=?');
        return $stmt->execute([$id]);
    }
}

class TypeTraitementModel {
    private PDO $db;
    public function __construct() {
        $this->db = Database::getInstance();
    }
    public function getAll(): array {
        return $this->db->query('SELECT * FROM types_traitement ORDER BY traitement')->fetchAll();
    }
    public function create(array $data): bool {
        $stmt = $this->db->prepare('INSERT INTO types_traitement (traitement, qte_pack, prix_pack) VALUES(?,?,?)');
        return $stmt->execute([$data['traitement'], $data['qte_pack'], $data['prix_pack']]);
    }
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare('UPDATE types_traitement SET traitement=?, qte_pack=?, prix_pack=? WHERE id=?');
        return $stmt->execute([$data['traitement'], $data['qte_pack'], $data['prix_pack'], $id]);
    }
    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM types_traitement WHERE id=?');
        return $stmt->execute([$id]);
    }
}

class TarificationModel {
    private PDO $db;
    public function __construct() {
        $this->db = Database::getInstance();
    }
    public function getAll(): array {
        return $this->db->query('SELECT t.*, tv.libelle AS vetement, tt.traitement FROM tarifications t
            LEFT JOIN types_vetement tv ON t.type_vetement_id=tv.id
            LEFT JOIN types_traitement tt ON t.type_traitement_id=tt.id
            ORDER BY tv.libelle, tt.traitement')->fetchAll();
    }
    public function create(array $data): bool {
        $stmt = $this->db->prepare('INSERT INTO tarifications (type_vetement_id, type_traitement_id, tarif, promotion) VALUES(?,?,?,?)');
        return $stmt->execute([$data['type_vetement_id'], $data['type_traitement_id'], $data['tarif'], $data['promotion']]);
    }
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare('UPDATE tarifications SET type_vetement_id = ?, type_traitement_id = ?, tarif = ?, promotion = ? WHERE id = ?');
        return $stmt->execute([$data['type_vetement_id'], $data['type_traitement_id'], $data['tarif'], $data['promotion'], $id]);
    }
    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM tarifications WHERE id=?');
        return $stmt->execute([$id]);
    }
}

/* Renommé en Lignes_caisseModel pour correspondre exactement à ton contrôleur */
class Lignes_caisseModel {
    private PDO $db;
    public function __construct(){
        $this->db = Database::getInstance();
    }
    
    // CORRECTION : Nettoyage de la double déclaration sur une seule ligne
    public function getAll(): array { 
        return $this->db->query('SELECT * FROM lignes_caisse ORDER BY libelle')->fetchAll();
    }
    
    public function create(array $d): bool { 
        $s = $this->db->prepare('INSERT INTO lignes_caisse (libelle, sens) VALUES (?,?)');
        return $s->execute([$d['libelle'], $d['sens'] ?? 'Entrée']);
    }

    // CORRECTION : Ajout de la méthode update() manquante requise par ton contrôleur
    public function update(int $id, array $d): bool {
        $s = $this->db->prepare('UPDATE lignes_caisse SET libelle = ?, sens = ? WHERE id = ?');
        return $s->execute([$d['libelle'], $d['sens'] ?? 'Entrée', $id]);
    }
    
    public function delete(int $id): bool { 
        $s = $this->db->prepare('DELETE FROM lignes_caisse WHERE id=?');
        return $s->execute([$id]);
    }  
}

/* Renommé en StructuresModel pour correspondre exactement à ton contrôleur */
class StructuresModel {
    private PDO $db;
    public function __construct(){
        $this->db = Database::getInstance();
    }
    
    public function getAll(): array { 
        return $this->db->query('SELECT * FROM structures ORDER BY id')->fetchAll();
    }
    
    public function getPrincipal(): ?array { 
        return $this->db->query('SELECT * FROM structures LIMIT 1')->fetch() ?: null;
    }
    
    public function getById(int $id): ?array { 
        $s = $this->db->prepare('SELECT * FROM structures WHERE id=?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }
    
    public function create(array $d): bool { 
    $s = $this->db->prepare('INSERT INTO structures (libelle, situation_geo, ville, telephone, email, gerant, type, magasin_depot) VALUES (?,?,?,?,?,?,?,?)');
    return $s->execute([
        $d['libelle'],
        $d['situation_geo'] ?? '',
        $d['ville']         ?? '',
        $d['telephone']     ?? '',
        $d['email']         ?? '',
        $d['gerant']        ?? '',
        $d['type']          ?? 'Pressing',
        $d['magasin_depot'] ?? 0
        ]);
    }
    
    public function update(int $id, array $d): bool { 
    $s = $this->db->prepare('UPDATE structures SET libelle=?, situation_geo=?, ville=?, telephone=?, email=?, gerant=?, type=?, magasin_depot=? WHERE id=?');
    return $s->execute([
        $d['libelle'],
        $d['situation_geo'] ?? '',
        $d['ville']         ?? '',
        $d['telephone']     ?? '',
        $d['email']         ?? '',
        $d['gerant']        ?? '',
        $d['type']          ?? 'Pressing',
        $d['magasin_depot'] ?? 0,
        $id
        ]);
    }
    
    public function delete(int $id): bool { 
        $s = $this->db->prepare('DELETE FROM structures WHERE id=?');
        return $s->execute([$id]); 
    }
}