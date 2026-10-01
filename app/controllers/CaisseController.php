<?php
// Inclut le contrôleur de base et le modèle de la caisse
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/CaisseModel.php';

class CaisseController extends Controller {

    // Action : Enregistrer une opération (Entrée / Sortie)
    public function store(): void {
        $this->requireAuth();
        $model = new CaisseModel();
        // Récupération et sécurisation des données POST
        $data = [
            'libelle' => $_POST['libelle'] ?? '',
            'motif'   => $_POST['motif'] ?? '',
            'montant' => floatval($_POST['montant'] ?? 0),
            'sens'    => $_POST['sens'] ?? '', // 'entree' ou 'sortie'
            'date_op' => $_POST['date_op'] ?? date('Y-m-d'),
        ];
        // Enregistrement
        if (!empty($data['libelle']) && $data['montant'] > 0 && !empty($data['sens'])) {
            $model->create($data);
        }
        // Redirection propre vers les opérations de caisse
        $this->redirect('/caisse/operations');
    }

    // Action : Afficher les opérations de caisse (URL: /caisse/operations)
    public function operations(): void {
        $model = new CaisseModel();
        $debut = $_GET['date_debut'] ?? date('Y-m-01');
        $fin = $_GET['date_fin'] ?? date('Y-m-t');
        $operations = $model->getOperations($debut, $fin);
        $balance = $model->getBalance($debut, $fin);
        $data = [
            'pageTitle'  => 'OPERATIONS DE CAISSE',
            'telephone'  => '',
            'debut'      => $debut,
            'fin'        => $fin,
            'operations' => $operations,
            'balance'    => $balance
        ];
        
        $this->render('caisse/operations', $data);
    }

    // Action : Afficher la balance de caisse (URL: /caisse/balance)
    public function balance(): void {
        $model = new CaisseModel();
        
        $debut = $_GET['date_debut'] ?? date('Y-m-01');
        $fin = $_GET['date_fin'] ?? date('Y-m-t');
        
        $balance = $model->getBalance($debut, $fin);
        
        $data = [
            'pageTitle' => 'BALANCE DE CAISSE',
            'telephone' => '',
            'debut'     => $debut,
            'fin'       => $fin,
            'balance'   => $balance,
        ];
        $this->render('caisse/balance', $data);
    }

    // Action : Afficher le recouvrement client (URL: /caisse/recouvrement)
    public function recouvrement(): void {
        $data = [
            'pageTitle' => 'RECOUVREMENT CLIENTS',
            'telephone' => '',
        ];
        $this->render('caisse/recouvrement', $data);
    }
}