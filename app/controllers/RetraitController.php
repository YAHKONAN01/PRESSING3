<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/RetraitModel.php'; // Changement de modèle ici

class RetraitController extends Controller {

    /**
     * URL : /retrait
     * Affiche la liste globale de tous les retraits prêts (tableau du haut)
     */
    public function index(): void {
        $this->requireAuth();
        $model = new RetraitModel();
        
        // On récupère TOUS les dépôts qui ont au moins un article emballé
        $retraitsEnAttente = $model->getDepotsPrets();

        $data = [
            'pageTitle'         => 'RETRAIT DE VÊTEMENTS',
            'retraitsEnAttente' => $retraitsEnAttente,
            'telephone'         => '' // Évite le warning du header si toujours présent
        ];

        // Envoie vers la vue interactive
        $this->render('retrait/index', $data);
    }

    /**
     * URL : /retrait/getLignes
     * Route AJAX appelée au clic sur un client pour charger ses articles (tableau du bas)
     */
    public function getLignes(): void {
        $depotId = (int)($_GET['depot_id'] ?? 0);
        $model = new RetraitModel();
        $lignes = $model->getLignesDepot($depotId);
        
        // On renvoie les données proprement au format JSON pour le script JS
        header('Content-Type: application/json');
        echo json_encode($lignes);
        exit;
    }

    /**
     * URL : /retrait/save
     * Traite la validation du retrait et du paiement (Bouton Enregistrer)
     */
    public function save(): void {
        // Ajustement des clés POST basées sur les inputs de la nouvelle vue
        $depotId = (int)($_POST['depot_id'] ?? 0);
        $montantSaisi = (int)($_POST['montant_paye'] ?? 0); 

        if ($depotId > 0) {
            $model = new RetraitModel();
            $model->finaliserRetrait($depotId, $montantSaisi);
        }

        $_SESSION['success'] = "Le retrait a été enregistré avec succès !";
        $this->redirect('/retrait');
    }
}