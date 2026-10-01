<?php
// Classe Database utilisant le pattern Singleton pour avoir une seule connexion active
class Database {
    // Stocke l'unique instance de connexion (PDO) pour la réutiliser
    private static ?PDO $instance = null;

    // Méthode publique pour récupérer ou créer la connexion à la base de données
    public static function getInstance(): PDO {
        // Si aucune connexion n'existe encore, on la crée
        if (self::$instance === null) {
            // Construit la chaîne de configuration de la BDD (Hôte, Nom de la base, Encodage)
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            try {
                // Tente de créer la connexion PDO avec les identifiants et options de sécurité
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active les rapports d'erreurs SQL
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Renvoie les résultats sous forme de tableaux associatifs
                ]);
            } catch (PDOException $e) {
                // Si la connexion échoue, le script s'arrête et affiche le message d'erreur
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
        // Renvoie l'instance de connexion active
        return self::$instance;
    }
}