
<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/FichiersModel.php'; 

class FichiersController extends Controller {

    public function vetements(): void {
        $this->requireAuth();
        $model = new TypeVetementModel();
        $data = [
            'pageTitle' => 'TYPE DE VÊTEMENT',
            'telephone' => '',
            'vetements' => $model->getAll(),
        ];
        $this->render('fichiers/vetements', $data);
    }

    public function vetementSave(): void {
        $model = new TypeVetementModel();
        
        $data = [
            'libelle'     => $_POST['libelle']     ?? '',
            'tarif'        => $_POST['tarif']        ?? 0,
            'description' => $_POST['description'] ?? '',
            'pack'        => $_POST['pack']        ?? 0,
        ];

        $id = (int)($_POST['id'] ?? 0);

        if ($id) {
            $model->update($id, $data);
        } else {
            $model->create($data);
        }

        $this->redirect('/fichiers/vetements');
    }

    public function vetementDelete(): void {
        $id = (int)($_POST['id'] ?? 0);
        $model = new TypeVetementModel();
        $model->delete($id);
        $this->redirect('/fichiers/vetements');
    }

    public function traitements(): void {
        $model = new TypeTraitementModel();
        $data = [
            'pageTitle'   => 'TYPE TRAITEMENT',
            'telephone'   => '',
            'traitements' => $model->getAll(),
        ];
        $this->render('fichiers/traitements', $data);
    }

    public function traitementSave(): void {
        $model = new TypeTraitementModel();
        
        $data = [
            'traitement' => $_POST['traitement'] ?? '',
            'qte_pack'   => (int)($_POST['qte_pack'] ?? 0),
            'prix_pack'  => (float)($_POST['prix_pack'] ?? 0),
        ];

        $id = (int)($_POST['id'] ?? 0);

        if ($id) {
            $model->update($id, $data);
        } else {
            $model->create($data);
        }

        $this->redirect('/fichiers/traitements');
    }

    public function traitementDelete(): void {
        $id = (int)($_POST['id'] ?? 0);
        $model = new TypeTraitementModel();
        $model->delete($id);
        $this->redirect('/fichiers/traitements');
    }

    public function tarifications(): void {
    $model = new TarificationModel();
    $vetModel = new TypeVetementModel();
    $traitModel = new TypeTraitementModel();
    
    $data = [
        'pageTitle'     => 'TARIFICATIONS',
        'telephone'     => '',
        'tarifications' => $model->getAll(),
        'vetements'     => $vetModel->getAll(),
        'traitements'   => $traitModel->getAll(),
    ];
    $this->render('fichiers/tarifications', $data);
}
    

    public function tarificationSave(): void {
        $model = new TarificationModel();
        
        $data = [
            'type_vetement_id'   => (int)($_POST['type_vetement_id'] ?? 0),
            'type_traitement_id' => (int)($_POST['type_traitement_id'] ?? 0),
            'tarif'              => (int)($_POST['tarif'] ?? 0),
            'promotion'          => (int)($_POST['promotion'] ?? 0),
        ];

        $id = (int)($_POST['id'] ?? 0);

        if ($id) {
            $model->update($id, $data);
        } else {
            $model->create($data);
        }

        $this->redirect('/fichiers/tarifications');
    }

    public function tarificationDelete(): void {
        $id = (int)($_POST['id'] ?? 0);
        $model = new TarificationModel();
        $model->delete($id);
        $this->redirect('/fichiers/tarifications');
    }

    public function lignes_caisse(): void {
        $model = new Lignes_caisseModel();
        $data = [
            'pageTitle'     => 'LIGNE DE CAISSE',
            'telephone'     => '',
            'lignes_caisse' => $model->getAll(), 
        ];
        $this->render('fichiers/lignes_caisse', $data);
    }

    public function lignes_caisseSave(): void {
        $model = new Lignes_caisseModel();
        
        $data = [
            'libelle' => $_POST['libelle'] ?? '',
            'sens'    => $_POST['sens'] ?? '', 
        ];

        $id = (int)($_POST['id'] ?? 0);

        if ($id) {
            $model->update($id, $data);
        } else {
            $model->create($data);
        }

        $this->redirect('/fichiers/lignes_caisse');
    }

    public function lignes_caisseDelete(): void {
        $id = (int)($_POST['id'] ?? 0);
        $model = new Lignes_caisseModel();
        $model->delete($id);
        $this->redirect('/fichiers/lignes_caisse');
    }

    public function structures(): void {
        $model = new StructuresModel();
        $data = [
            'pageTitle' => 'STRUCTURE',
            'telephone' => '',
            'structures' => $model->getAll(),
        ];
        $this->render('fichiers/structures', $data);
    }

   public function structureSave(): void {
    $model = new StructuresModel();
    
    $data = [
        'libelle'       => $_POST['libelle'] ?? '',
        'situation_geo' => $_POST['situation_geo'] ?? '',
        'ville'         => $_POST['ville'] ?? '',       
        'telephone'     => $_POST['telephone'] ?? '',   
        'email'         => $_POST['email'] ?? '',
        'gerant'        => $_POST['gerant'] ?? '',
        'type'          => $_POST['type'] ?? '',
        'magasin_depot' => $_POST['magasin_depot'] ?? '',
    ];

    $id = (int)($_POST['id'] ?? 0);

    if ($id) {
        $model->update($id, $data);
    } else {
        $model->create($data);
    }

    $this->redirect('/fichiers/structure');
}

    public function structureDelete(): void {
        $id = (int)($_POST['id'] ?? 0);
        $model = new StructuresModel();
        $model->delete($id);
        $this->redirect('/fichiers/structures');
    }
}