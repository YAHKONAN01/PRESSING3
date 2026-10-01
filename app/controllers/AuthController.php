<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/AuthModel.php';

class AuthController extends Controller {

    public function loginForm(): void {
        // Si déjà connecté, on redirige vers l'accueil
        if (!empty($_SESSION['admin'])) {
            $this->redirect('/');
        }

        $this->render('auth/login');
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $authModel = new AuthModel();
            $admin = $authModel->verifierConnexion($username, $password);

            if ($admin) {
                // Authentification réussie
                $_SESSION['admin'] = $admin;
                $this->redirect('/');
            } else {
                // Échec : on stocke l'erreur dans la session que ta vue attend
                $_SESSION['erreur_login'] = 'Identifiant ou mot de passe incorrect.';
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function logout(): void {
        unset($_SESSION['admin']);
        session_destroy();
        $this->redirect('/login');
    }
}