<?php
// Inclut la classe de base du Contrôleur principal
require_once BASE_PATH . '/app/core/Controller.php';

// Contrôleur pour gérer la page d'accueil de l'application
class AccueilController extends Controller {

    // Méthode principale qui affiche la page d'accueil
    public function index(): void {
        $this->requireAuth();
        // Préparation des données de base de la page
        $data = [
        	'pageTitle' => 'Accueil',
        	'telephone' => '+225 07 00 00 00 00',
        ];
        
        // Envoie les données et affiche la vue 'accueil/index'
        $this->render('accueil/index', $data);
    }

}