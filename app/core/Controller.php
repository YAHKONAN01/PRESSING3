<?php
// Contrôleur de base (Parent) qui contient les fonctions partagées de l'application
class Controller {

    public function __construct() {
        // Démarre la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Permet de charger un fichier de vue HTML/PHP et de lui envoyer des données
    protected function render(string $view, array $data = []): void {
        extract($data); 
        $file = BASE_PATH . '/app/views/' . $view . '.php'; 
        
        if (!file_exists($file)) {
            die("Vue introuvable : $file");
        }
        require $file; 
    }

    // Permet de rediriger l'utilisateur vers une autre page du site
    protected function redirect(string $url): void {
        header('Location: ' . APP_URL . $url); 
        exit; 
    }

    // Vérifie si l'administrateur est connecté, sinon redirige vers /login
    protected function requireAuth(): void {
        if (empty($_SESSION['admin'])) {
            $this->redirect('/login');
        }
    }
}