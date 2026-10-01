<?php // Inclut le haut de page (menu de navigation) ?>
<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center my-4">
    
    <div class="form-card">
        
        <div class="form-card-header text-uppercase">
            <i class="bi bi-person-fill-add me-2"></i> Ajouter un client
        </div>
        
        <div class="p-4">
            <form method="POST" action="<?= APP_URL ?>/clients/save">
                
                <input type="hidden" name="id" value="">

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-uppercase">Nom & Prénoms *</label>
                        <input type="text" name="nom_prenoms" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-uppercase">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" placeholder="+225 07 XX XX XX XX">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-uppercase">Situation géo.</label>
                        <input type="text" name="situation_geo" class="form-control" placeholder="Quartier, adresse...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-uppercase">Ville</label>
                        <input type="text" name="ville" class="form-control">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-uppercase">Mode de retrait</label>
                        <select name="mode_retrait" class="form-select">
                            <option value="Retrait au dépôt" selected>Retrait au dépôt</option>
                            <option value="Livraison à domicile">Livraison à domicile</option>
                            <option value="Livraison bureau">Livraison bureau</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-uppercase">Frais livraison (FCFA)</label>
                        <input type="number" name="frais_livraison" class="form-control" value="0">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-uppercase">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Ex: client@gmail.com">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-custom-save">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                    <a href="<?= APP_URL ?>/clients" class="btn-custom-cancel text-decoration-none d-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i> Annuler
                    </a>
                </div>
                    
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #bce3ff; /* Le fond bleu clair de ton appli */
        font-family: sans-serif;
    }

    /* Conteneur principal du formulaire (Card) */
    .form-card {
        background: white;
        border-radius: 4px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #bdc3c7;
        overflow: hidden;
        max-width: 750px;
        width: 100%;
    }

    /* En-tête bleu foncé du formulaire */
    .form-card-header {
        background-color: #1a237e; /* Même bleu foncé que ta barre de menu */
        color: white;
        padding: 10px 15px;
        font-weight: bold;
        font-size: 14px;
        letter-spacing: 1px;
    }

    /* Libellés des champs (Labels) */
    .form-label {
        color: #2c3e50;
        font-weight: bold;
        font-size: 13px;
        margin-bottom: 4px;
    }

    /* Style des champs de saisie */
    .form-control, .form-select {
        border: 1px solid #95a5a6;
        border-radius: 4px;
        padding: 6px 10px;
        font-size: 14px;
        color: #333;
    }

    /* Supprime l'effet bleu d'origine Bootstrap au clic */
    .form-control:focus, .form-select:focus {
        border-color: #1a237e;
        box-shadow: none;
    }

    /* Boutons personnalisés conformes à l'image */
    .btn-custom-save {
        background-color: #0d6efd;
        color: white;
        border: none;
        font-size: 13px;
        font-weight: bold;
        padding: 6px 16px;
        border-radius: 4px;
        transition: background 0.2s;
    }
    .btn-custom-save:hover {
        background-color: #0b5ed7;
    }

    .btn-custom-cancel {
        background-color: #c0392b;
        color: white;
        border: none;
        font-size: 13px;
        font-weight: bold;
        padding: 6px 16px;
        border-radius: 4px;
        transition: background 0.2s;
    }
    .btn-custom-cancel:hover {
        background-color: #a93226;
    }
</style>

<?php // Inclut le bas de page (scripts JavaScript et fermeture des balises) ?>
<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>