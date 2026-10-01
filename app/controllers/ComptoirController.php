<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/DepotModel.php';

class ComptoirController extends Controller {

    public function reception(): void {
        $this->requireAuth();
        $model = new DepotModel();
        $data = [
            'pageTitle' => 'COMPTOIR DE RÉCEPTION',
            'telephone' => '',
            'vetements' => $model->getTypesVetement(), // Chargement des types de vêtements depuis la DB
            'depots'    => $model->getAll(),
        ];
        $this->render('comptoir/reception', $data);
    }

    public function enregistrer(): void {
        $model  = new DepotModel();
        $panier = json_decode($_POST['panier'] ?? '[]', true);

        if (empty($panier) || !is_array($panier)) {
            $this->redirect('/comptoir/reception');
            return;
        }

        try {
            $total       = array_sum(array_column($panier, 'montant'));
            $reduction   = (int)($_POST['reduction'] ?? 0);
            $netAPayer   = $total - $reduction;
            $montantPaye = (int)($_POST['montant_paye'] ?? 0);

            $code = $model->create([
                'client_nom'       => $_POST['client_nom']        ?? '',
                'client_telephone' => $_POST['client_telephone'] ?? '',
                'client_residence' => $_POST['client_residence'] ?? '',
                'mode_retrait'     => $_POST['mode_retrait']      ?? 'Retrait au dépôt',
                'montant_total'    => $total,
                'reduction'        => $reduction,
                'net_a_payer'      => $netAPayer,
                'montant_paye'     => $montantPaye,
                'reste_a_payer'    => max(0, $netAPayer - $montantPaye),
                'date_depot'       => date('Y-m-d'),
                'date_retrait'     => $_POST['date_retrait']     ?? null,
                'heure_retrait'    => $_POST['heure_retrait']    ?? null,
            ]);

            // Récupérer l'ID du dépôt créé
            $depotId = $model->getIdByCode($code);
            
            if ($depotId === 0) {
                throw new Exception("Impossible de récupérer l'ID du dépôt.");
            }

            foreach ($panier as $item) {
                $model->addLigne($depotId, [
                    'designation' => $item['designation'] ?? 'Inconnu',
                    'description' => $item['description'] ?? '',
                    'service'     => $item['service']     ?? 'Pressing',
                    'observation' => $item['observation'] ?? '',
                    'tarif'       => $item['tarif']       ?? 0,
                    'quantite'    => $item['quantite']    ?? 1,
                    'montant'     => $item['montant']     ?? 0,
                ]);
            }

            // Si tout s'est bien passé
            $_SESSION['code_depot'] = $code;
            $this->redirect('/comptoir/confirmation');

        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement.";
            $this->redirect('/comptoir/reception');
        }
    }

    public function confirmation(): void {
        $code = $_SESSION['code_depot'] ?? null;
        
        if (!$code) {
            $this->redirect('/comptoir/reception');
            return;
        }

        $model  = new DepotModel();
        $depot  = $model->getByCode($code);
        
        if (!$depot) {
            $this->redirect('/comptoir/reception');
            return;
        }

        $lignes = $model->getLignes($depot['id']);

        unset($_SESSION['code_depot']);

        $data = [
            'pageTitle' => 'CONFIRMATION DE DÉPÔT',
            'telephone' => '',
            'depot'     => $depot,
            'lignes'    => $lignes,
        ];

        $this->render('comptoir/confirmation', $data);
    }

    // TRANSFERT EN SALLE MACHINE
    public function transfert(): void {
        $model = new DepotModel();
        $data = [
            'pageTitle' => 'TRANSFERT EN SALLE MACHINE',
            'telephone' => '',
            'lignes'    => $model->getLignesParStatut('en_attente'),
        ];
        $this->render('comptoir/transfert', $data);
    }

    public function transfertSave(): void {
        $ids = json_decode($_POST['ids'] ?? '[]', true);
        if (is_array($ids)) {
            $model = new DepotModel();
            foreach ($ids as $id) {
                $model->updateStatutLigne((int)$id, 'transfere');
            }
        }
        $this->redirect('/comptoir/transfert');
    }

    // CONFIRMATION DE TRAITEMENT
    public function traitement(): void {
        $model = new DepotModel();
        $data = [
            'pageTitle' => 'CONFIRMATION DES TRAITEMENTS',
            'telephone' => '',
            'lignes'    => $model->getLignesParStatut('transfere'),
        ];
        $this->render('comptoir/traitement', $data);
    }

    public function traitementSave(): void {
        $ids = json_decode($_POST['ids'] ?? '[]', true);
        if (is_array($ids)) {
            $model = new DepotModel();
            foreach ($ids as $id) {
                $model->updateStatutLigne((int)$id, 'traite');
            }
        }
        $this->redirect('/comptoir/traitement');
    }

    // MISE SOUS EMBALLAGE
    public function emballage(): void {
        $model = new DepotModel();
        $data = [
            'pageTitle' => 'MISE SOUS EMBALLAGE',
            'telephone' => '',
            'lignes'    => $model->getLignesParStatut('traite'),
        ];
        $this->render('comptoir/emballage', $data);
    }

    public function emballageSave(): void {
        $ids = json_decode($_POST['ids'] ?? '[]', true);
        if (is_array($ids)) {
            $model = new DepotModel();
            foreach ($ids as $id) {
                $model->updateStatutLigne((int)$id, 'emballe');
            }
        }
        $this->redirect('/comptoir/emballage');
    }

    // ENVOI SMS
    public function sms(): void {
        $data = [
            'pageTitle' => 'ENVOI SMS',
            'telephone' => '',
        ];
        $this->render('comptoir/sms', $data);
    }
}