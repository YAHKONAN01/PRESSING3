<?php // Inclut l'en-tête commun (barre de menu de l'application) ?>
<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="table-container">
    
    <div class="table-header-bar">
        <div class="table-header-title">
            <i class="bi bi-people-fill me-2"></i> LISTE DES CLIENTS
        </div>
        
        <div class="d-flex align-items-center gap-2">
            <form method="GET" action="" class="d-flex align-items-center m-0">
                <input type="text" name="search" class="form-control search-box" placeholder="Rechercher...">
                <button type="submit" class="btn-chercher">Chercher</button>
            </form>
            
            <a href="<?= APP_URL ?>/clients/nouveau" class="btn-nouveau">
                ✦ Nouveau +
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered custom-table">
            <thead>
                <tr>
                    <th>NOM & PRÉNOMS</th>
                    <th>SITUATION GÉO.</th>
                    <th>TÉLÉPHONE</th>
                    <th>MODE RETRAIT</th>
                    <th class="text-end">FRAIS LIVRAISON</th>
                    <th class="text-center" style="width: 110px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $client): ?>
                <tr>
                    <td><?= $client['nom_prenoms'] ?></td>
                    <td><?= $client['ville'] ?></td> 
                    <td><?= $client['telephone'] ?></td>
                    <td><?= $client['mode_retrait'] ?></td>
                    <td class="text-end fw-bold"><?= $client['frais_livraison'] ?> F</td>
                    
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            <a href="<?= APP_URL ?>/clients/nouveau?id=<?= $client['id'] ?>" class="btn-action-edit text-decoration-none d-inline-flex align-items-center justify-content-center" title="Modifier">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form method="POST" action="<?= APP_URL ?>/clients/delete" onsubmit="return confirm('Supprimer ce client ?')" class="m-0">
                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                <button type="submit" class="btn-action-delete" title="Supprimer">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    body {
        background-color: #bce3ff;
        font-family: sans-serif;
    }

    /* Cadre blanc complet du tableau */
    .table-container {
        background: white;
        border-radius: 4px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #bdc3c7;
        overflow: hidden;
        margin: 20px;
    }

    /* Bandeau bleu foncé */
    .table-header-bar {
        background-color: #1a237e;
        color: white;
        padding: 8px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .table-header-title {
        font-weight: bold;
        font-size: 14px;
        letter-spacing: 1px;
        margin: 0;
    }

    /* Barre de recherche intégrée */
    .search-box {
        max-width: 220px;
        height: 30px;
        font-size: 13px;
        border-radius: 4px 0 0 4px;
        border: 1px solid #bdc3c7;
    }

    /* Boutons jaunes (Chercher et Nouveau) */
    .btn-chercher {
        background-color: #ffcc00;
        color: black;
        font-weight: bold;
        border: none;
        height: 30px;
        padding: 0 15px;
        font-size: 13px;
        border-radius: 0 4px 4px 0;
    }

    .btn-nouveau {
        background-color: #ffcc00;
        color: black;
        font-weight: bold;
        border: none;
        height: 30px;
        padding: 0 15px;
        font-size: 13px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
    }

    /* --- TABLEAU STYLE NOIR & JAUNE --- */
    .custom-table {
        margin-bottom: 0 !important;
        font-size: 13px;
        vertical-align: middle;
    }

    /* En-tête noir et jaune */
    .custom-table thead {
        background-color: #111111 !important;
    }

    .custom-table thead th {
        color: #ffcc00 !important;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
        border: 1px solid #333 !important;
        padding: 8px 12px;
    }

    /* Bordures intérieures du tableau */
    .custom-table tbody td {
        color: #2c3e50;
        padding: 8px 12px;
        border: 1px solid #e2e8f0 !important;
    }

    /* Boutons d'actions carrés et colorés (Modifier / Supprimer) */
    .btn-action-edit {
        background-color: #ff9f43;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-action-delete {
        background-color: #ee5253;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 4px;
        font-size: 14px;
    }
</style>

<?php // Inclut le bas de page commun ?>
<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>