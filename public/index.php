<?php
// Inclut les fichiers de configuration et les classes de base (Base de données et Routeur)
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/app/core/Database.php';
require_once dirname(__DIR__) . '/app/core/Router.php';

// Initialise le routeur pour gérer les URLs du site
$router = new Router();

// Routes auth (les bonnes)
$router->get( '/login',  'AuthController', 'loginForm');
$router->post('/login',  'AuthController', 'login');
$router->get( '/logout', 'AuthController', 'logout');

// Route pour la page d'accueil
$router->get('/', 'AccueilController', 'index');

// Routes pour la gestion des clients (Affichage, Formulaire, Enregistrement, Suppression)
$router->get('/clients',         'ClientController', 'index');
$router->get('/clients/nouveau', 'ClientController', 'nouveau');
$router->post('/clients/save',   'ClientController', 'save');
$router->post('/clients/delete', 'ClientController', 'delete');


// --- SECTION : COMPTOIR (RÉCEPTION) ---
$router->get('/comptoir/reception',        'ComptoirController', 'reception');
$router->post('/comptoir/reception/save', 'ComptoirController', 'enregistrer');
$router->get('/comptoir/confirmation',    'ComptoirController', 'confirmation');

$router->get( '/comptoir/transfert',        'ComptoirController', 'transfert');
$router->post('/comptoir/transfert/save',  'ComptoirController', 'transfertSave');

$router->get( '/comptoir/traitement',       'ComptoirController', 'traitement');
$router->post('/comptoir/traitement/save', 'ComptoirController', 'traitementSave');

$router->get( '/comptoir/emballage',        'ComptoirController', 'emballage');
$router->post('/comptoir/emballage/save',  'ComptoirController', 'emballageSave');

$router->get( '/comptoir/sms',              'ComptoirController', 'sms');


// --- SECTION : FICHIERS - VÊTEMENTS ---
$router->get( '/fichiers/vetements',         'FichiersController', 'vetements');
$router->post('/fichiers/vetements/save',   'FichiersController', 'vetementSave');
$router->post('/fichiers/vetements/delete', 'FichiersController', 'vetementDelete');

// --- SECTION : FICHIERS - TYPES DE TRAITEMENT ---
$router->get( '/fichiers/traitements',         'FichiersController', 'traitements');
$router->post('/fichiers/traitements/save',   'FichiersController', 'traitementSave');
$router->post('/fichiers/traitements/delete', 'FichiersController', 'traitementDelete');


// --- SECTION : FICHIERS - TARIFICATION ---
$router->get('/fichiers/tarifications',         'FichiersController', 'tarifications');
$router->post('/fichiers/tarifications/save',   'FichiersController', 'tarificationSave');
$router->post('/fichiers/tarifications/delete', 'FichiersController', 'tarificationDelete');

// --- SECTION : FICHIERS - LIGNE DE CAISSE ---
$router->get('/fichiers/lignes_caisse',         'FichiersController', 'lignes_caisse');
$router->post('/fichiers/lignes_caisse/save',   'FichiersController', 'lignes_caisseSave');
$router->post('/fichiers/lignes_caisse/delete', 'FichiersController', 'lignes_caisseDelete');


// --- SECTION : FICHIERS - STRUCTURE ---
$router->get('/fichiers/structure',         'FichiersController', 'structures');
$router->post('/fichiers/structure/save',   'FichiersController', 'structureSave');
$router->post('/fichiers/structure/delete', 'FichiersController', 'structureDelete');


// --- SECTION : RETRAIT DE VETEMENT ---
$router->get('/retrait',               'RetraitController', 'index');
$router->get('/retrait/getLignes',    'RetraitController', 'getLignes');
$router->post('/retrait/save',         'RetraitController', 'save');


// --- SECTION : CAISSE ---
$router->get('/caisse/operations',          'CaisseController', 'operations');
$router->post('/caisse/save',               'CaisseController', 'store');
$router->get('/caisse/balance',             'CaisseController', 'balance');
$router->get('/caisse/recouvrement',        'RecouvrementController', 'index');
$router->post('/caisse/recouvrement/payer', 'RecouvrementController', 'payer');


// TABLEAU DE BORD
$router->get('/tableau-de-bord', 'TableauController', 'index');

// Exécution du routeur
$router->dispatch();