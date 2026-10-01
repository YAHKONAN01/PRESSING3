<?php
// Inclut le contrôleur de base et le modèle des clients
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/ClientModel.php';

// Contrôleur qui gère les actions liées aux clients (Afficher, Ajouter, Enregistrer, Supprimer)
class ClientController extends Controller {

    // Affiche la liste de tous les clients
    public function index(): void {
    	$model = new ClientModel();
    	$clients = $model->getALL(); // Récupère les clients depuis la BDD
        $data = [
         'pageTitle' => 'LISTE CLIENTS',
         'telephone' => '',
         'clients'   => $clients,   
        ];
        $this->render('clients/index', $data); // Charge la page liste
    }

    // Affiche le formulaire pour ajouter un nouveau client
    public function nouveau(): void {
    $data = [
        'pageTitle' => 'AJOUTER UN CLIENT',
        'telephone' => '',
    ];
     $this->render('clients/form', $data); // Charge la page formulaire
}
    
    // Enregistre les données du formulaire (Ajout ou Modification)
    public function save(): void {
    $model = new ClientModel();
    	
    // Récupère et sécurise les données envoyées par le formulaire ($_POST)
    $data = [
        'nom_prenoms'    => $_POST['nom_prenoms']    ?? '',
        'telephone'      => $_POST['telephone']      ?? '',
        'situation_geo'  => $_POST['situation_geo']  ?? '',
        'ville'          => $_POST['ville']          ?? '',
        'mode_retrait'   => $_POST['mode_retrait']   ?? 'Retrait au dépôt',
        'frais_livraison'=> $_POST['frais_livraison']?? 0,
        'email'          => $_POST['email']          ?? '',
    ];

    // Vérifie si un ID existe pour savoir s'il s'agit d'une modification
    $id = (int)($_POST['id'] ?? 0);

    if ($id) {
        // Si l'ID existe, on met à jour le client
        $model->update($id, $data);
    } else {
        // Si pas d'ID, on crée un nouveau client
        $model->create($data);
    }

    // Redirige l'utilisateur vers la liste des clients après enregistrement
    $this->redirect('/clients');
}

// Supprime un client via son ID
public function delete(): void {
    $id = (int)($_POST['id'] ?? 0); // Récupère l'ID du client à supprimer
    $model = new ClientModel();
    $model->delete($id); // Exécute la suppression en BDD
    $this->redirect('/clients'); // Redirige vers la liste des clients
}

}