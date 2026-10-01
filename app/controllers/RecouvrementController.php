<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/RecouvrementModel.php';

class RecouvrementController extends Controller {

    // Action : Afficher la liste des impayés + détail d'un dépôt sélectionné
    public function index(): void {
        $this->requireAuth();
        $model = new RecouvrementModel();

        // Filtres (dates + client)
        $debut = $_GET['date_debut'] ?? null;
        $fin = $_GET['date_fin'] ?? null;
        $clientId = !empty($_GET['client_id']) ? (int)$_GET['client_id'] : null;

        $impayes = $model->getImpayes($debut, $fin, $clientId);
        $clients = $model->getClients();

        // Si un dépôt est sélectionné (clic sur une ligne), on charge son détail
        $depotSelectionne = null;
        $lignes = [];
        $depotId = !empty($_GET['depot_id']) ? (int)$_GET['depot_id'] : null;

        if ($depotId) {
            $depotSelectionne = $model->getDepotById($depotId);
            $lignes = $model->getLignesByDepot($depotId);
        }

        $data = [
            'pageTitle'        => 'RECOUVREMENTS CLIENTS',
            'telephone'        => '',
            'impayes'          => $impayes,
            'clients'          => $clients,
            'debut'            => $debut,
            'fin'              => $fin,
            'clientId'         => $clientId,
            'depotSelectionne' => $depotSelectionne,
            'lignes'           => $lignes,
        ];
        $this->render('caisse/recouvrement', $data);
    }

    // Action : Enregistrer un paiement / retrait
    public function payer(): void {
        $model = new RecouvrementModel();

        $depotId        = (int)($_POST['id'] ?? 0);
        $montant        = (float)($_POST['montant'] ?? 0);
        $modeReglement  = $_POST['mode_reglement'] ?? '';
        $reference      = $_POST['reference_paiement'] ?? '';
        $type           = $_POST['type'] ?? 'paiement'; // paiement | retrait | les_deux

        if ($depotId) {
            $model->payer($depotId, $montant, $modeReglement, $reference, $type);
        }

        $this->redirect('/caisse/recouvrement');
    }
}