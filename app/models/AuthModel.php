<?php
class AuthModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function verifierConnexion(string $username, string $password): ?array {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return null;
    }
}