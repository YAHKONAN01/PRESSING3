<?php // Début du fichier HTML global ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<style>
    /* Configuration globale pour permettre aux fenêtres de s'étendre à 100% */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    /* Au survol (hover) sur les onglets de la navbar */
    .navbar-nav .nav-link:hover {
        color: #f5c518 !important; /* Le texte devient jaune au survol */
        transition: color 0.2s ease-in-out; /* Rend le changement de couleur fluide */
    }

    /* Si tu as mis une icône dans l'onglet, elle changera aussi de couleur au survol */
    .navbar-nav .nav-link:hover i {
        color: #f5c518 !important;
    }

    /* Icônes de contrôle de fenêtre (Survol) */
    .ctrl-btn {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .ctrl-btn:hover {
        color: #f5c518 !important;
        transform: scale(1.15);
    }
    .ctrl-close:hover {
        color: #ff1744 !important;
    }

    /* Classe injectée par JavaScript pour le mode plein écran de l'application */
    .vue-plein-ecran {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 10000 !important;
        background: #f8f9fa !important;
        overflow-y: auto !important;
        padding: 15px !important;
    }
</style>

<nav class="navbar" style="background:#0d47a1; padding:4px 16px;">
  <div class="d-flex align-items-center w-100">

    <span class="badge me-3" style="background:#f5c518; color:#000; font-size:11px; letter-spacing:2px;">
      PRESSING
    </span>

    <span class="text-white fw-bold flex-grow-1" style="font-size:13px; letter-spacing:1px;">
      <?= $pageTitle ?>
    </span>

    <span style="color:#f5c518; font-weight:900; font-size:14px;" class="me-4">
       <span><?= $telephone ?? '' ?></span>
    </span>

    <div class="d-flex gap-3 align-items-center border-start ps-3" style="border-color: rgba(255, 255, 255, 0.25) !important;">
      <span class="text-white-50 ctrl-btn" onclick="boutonReduire()" title="Réduire le contenu">
        <i class="bi bi-dash-lg" style="font-size: 15px;"></i>
      </span>
      <span class="text-white-50 ctrl-btn" onclick="boutonAgrandir()" title="Agrandir / Normal">
        <i class="bi bi-square" style="font-size: 11px;"></i>
      </span>
      <span class="text-danger fw-bold ctrl-btn ctrl-close" onclick="boutonFermer()" title="Fermer la page">
        <i class="bi bi-x-lg" style="font-size: 15px;"></i>
      </span>
    </div>
    

  </div>
</nav>

<nav class="navbar navbar-expand-lg" style="background:#1a237e; padding:2px 8px;">
  <ul class="navbar-nav d-flex flex-row gap-1">

    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size:11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-house me-2 text-warning"></i>
        FICHIERS
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/fichiers/structure"><i class="bi bi-house me-2 text-primary"></i>STRUCTURE</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/fichiers/lignes_caisse"><i class="bi bi-cash me-2 text-primary"></i>LIGNE DE CAISSE</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/fichiers/vetements"><i class="bi bi-bag me-2 text-primary"></i>TYPE DE VÊTEMENT</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/fichiers/traitements"><i class="bi bi-gear me-2 text-primary"></i>TYPE TRAITEMENT</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/fichiers/tarifications"><i class="bi bi-tags me-2 text-primary"></i>TARIFICATION</a></li>
      </ul>
    </li>

    <li class="nav-item"><span class="text-secondary px-1">|</span></li>

    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size:11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-box-seam me-2 text-warning"></i>
        STOCK PRODUIT
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/stock/produits"><i class="bi bi-box me-2 text-primary"></i>LISTE DES PRODUITS</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/stock/entree"><i class="bi bi-box-arrow-in-down me-2 text-primary"></i>ENTRÉE EN STOCK</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/stock/sortie"><i class="bi bi-box-arrow-up me-2 text-primary"></i>SORTIE DE STOCK</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/stock/etat"><i class="bi bi-clipboard-data me-2 text-primary"></i>ÉTAT DU STOCK</a></li>
      </ul>
    </li>

    <li class="nav-item"><span class="text-secondary px-1">|</span></li>

    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size: 11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-people me-2 text-warning"></i>
        CLIENTS 
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/clients"><i class="bi bi-people me-2 text-primary"></i>LISTE DES CLIENTS</a></li>
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/clients/nouveau"><i class="bi bi-person-plus me-2 text-primary"></i>AJOUTER UN CLIENT</a></li>      
      </ul>
    </li>

    <li class="nav-item"><span class="text-secondary px-1">|</span></li>

    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size: 11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-gear me-2 text-warning"></i>COMPTOIR</a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/comptoir/reception"><i class="bi bi-inbox me-2 text-primary"></i>RECEPTION DE VÊTEMENT</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/comptoir/transfert"><i class="bi bi-arrow-right-circle me-2 text-primary"></i>TRANSFERT EN SALLE MACHINE</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/comptoir/traitement"><i class="bi bi-check-circle me-2 text-primary"></i>CONFIRMATION DE TRAITEMENT</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/comptoir/emballage"><i class="bi bi-gift me-2 text-primary"></i>MISE SOUS EMBALLAGE</a></li>
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/comptoir/sms"><i class="bi bi-chat-dots me-2 text-primary"></i>ENVOI SMS</a></li>
      </ul>
    </li>

    <li class="nav-item"><span class="text-secondary px-1">|</span></li>
      
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size: 11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-bag-check me-2 text-warning"></i>RETRAIT</a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/retrait"><i class="bi bi-bag-check me-2 text-primary"></i>RETRAIT DE VÊTEMENT</a></li>
      </ul>
    </li>
    
    <li class="nav-item"><span class="text-secondary px-1">|</span></li>

    <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size: 11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-gear me-2 text-warning"></i>CAISSE</a>
      <ul class="dropdown-menu">
    <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/caisse/operations"><i class="bi bi-journal-text me-2 text-primary"></i>OPÉRATIONS DE CAISSE</a></li>
    <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/caisse/balance"><i class="bi bi-bar-chart me-2 text-primary"></i>BALANCE</a></li>
    <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/caisse/recouvrement"><i class="bi bi-people-fill me-2 text-primary"></i>RECOUVREMENT CLIENT</a></li>
</ul>
    </li>

    <li class="nav-item"><span class="text-secondary px-1">|</span></li>

    <li class="nav-item dropdown">
         <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size: 11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-file-earmark-text me-2 text-warning"></i>EDITIONS</a>
         <ul class="dropdown-menu">
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/editions/journal-des-depots"><i class="bi bi-file-text me-2 text-primary"></i>JOURNAL DES DEPOTS</a></li>
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/editions/journal-des-retraits"><i class="bi bi-file-tex me-2 text-primary"></i>JOURNAL DES RETRAITS</a></li>
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/editions/journal-des-vet"><i class="bi bi-file-text me-2 text-primary"></i>JOURNAL DES VÊT.NON TRAITE</a></li>
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/editions/journal-des-recettes"><i class="bi bi-file-text me-2 text-primary"></i>JOURNAL DES RECETTES</a></li>
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/editions/journal-des-factures-impayes"><i class="bi bi-file-text me-2 text-primary"></i>JOURNAL DES FACTURES IMPAYES</a></li>
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/editions/journal-des-vet-en-attente"><i class="bi bi-file-text me-2 text-primary"></i>JOURNAL DES VÊT.EN ATTENTE DE RETRAIT</a></li>
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/editions/journal-des-vetements-a-livre"><i class="bi bi-file-text me-2 text-primary"></i>JOURNAL DES VETEMENTS A LIVRER</a></li>
        </ul>
    </li>

    <li class="nav-item"><span class="text-secondary px-1">|</span></li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white fw-bold" style="font-size: 11px;" href="#" data-bs-toggle="dropdown"><i class="bi bi-speedometer2 me-2 text-warning"></i>TABLEAU DE BORD</a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item fw-bold text-danger" href="<?= APP_URL ?>/tableau-de-bord"><i class="bi bi-speedometer2 me-2 text-primary"></i>tableau de bord</a></li>
        </ul>
    </li>
  </ul>
</nav>

<script>
// 1. FERMER : Aucun problème ici, il fonctionne nickel
function boutonFermer() {
    if (confirm("Voulez-vous quitter cette section et retourner au menu principal ?")) {
        window.location.href = "<?= APP_URL ?>/";
    }
}

// Fonction interne pour trouver la zone de contenu de la page active
function obtenirConteneurPrincipal() {
    // Étape A : On cherche d'abord les classes standards de Bootstrap
    let conteneur = document.querySelector('.container-fluid') || document.querySelector('.container');
    
    // Étape B : Si on ne trouve rien (ex: structure personnalisée), on prend l'élément HTML principal qui suit le menu
    if (!conteneur) {
        // On récupère toutes les balises après le menu (les div, section, ou main)
        const toutesLesDivs = document.querySelectorAll('body > div, body > section, body > main');
        // On prend la première div qui n'est pas une de nos navbars
        for (let i = 0; i < toutesLesDivs.length; i++) {
            if (!toutesLesDivs[i].classList.contains('navbar')) {
                conteneur = toutesLesDivs[i];
                break;
            }
        }
    }
    return conteneur;
}

// 2. AGRANDIR : Passe désormais en plein écran peu importe la structure de la page
function boutonAgrandir() {
    const cible = obtenirConteneurPrincipal();
    if (cible) {
        cible.classList.toggle('vue-plein-ecran');
    } else {
        console.warn("Désolé, aucune zone de contenu n'a été détectée sous le menu pour l'agrandir.");
    }
}

// 3. RÉDUIRE : Masque ou affiche proprement le contenu de la page
function boutonReduire() {
    const cible = obtenirConteneurPrincipal();
    if (cible) {
        if (cible.style.display === 'none') {
            cible.style.display = ''; // Rétablit le style d'affichage par défaut (block, flex, etc.)
        } else {
            cible.style.display = 'none'; // Masque le bloc
        }
    } else {
        console.warn("Désolé, aucune zone de contenu n'a été détectée sous le menu pour la réduire.");
    }
}
</script>