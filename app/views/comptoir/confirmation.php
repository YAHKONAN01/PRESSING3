<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container mt-3" style="max-width:600px">
    <h5 class="fw-bold text-center mb-3">✅ DÉPÔT ENREGISTRÉ</h5>

    <!-- Code dépôt -->
    <div class="text-center mb-3 p-3" style="background:#fff8e1;border:2px dashed #f9a825;border-radius:8px">
        <div class="text-muted" style="font-size:11px">CODE DE DÉPÔT</div>
        <div style="font-size:28px;font-weight:900;color:#c62828;letter-spacing:3px">
            <?= $depot['code_depot'] ?>
        </div>
    </div>

    <!-- Infos client -->
    <div class="mb-3 p-3 bg-light rounded">
        <div><strong>Client :</strong> <?= $depot['client_nom'] ?></div>
        <div><strong>Téléphone :</strong> <?= $depot['client_telephone'] ?></div>
        <div><strong>Mode retrait :</strong> <?= $depot['mode_retrait'] ?></div>
    </div>

    <!-- Tableau articles -->
    <table class="table table-bordered table-sm mb-3">
        <thead class="table-dark">
            <tr>
                <th>DÉSIGNATION</th>
                <th>QTÉ</th>
                <th>TARIF</th>
                <th>MONTANT</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lignes as $ligne): ?>
            <tr>
                <td><?= $ligne['designation'] ?></td>
                <td><?= $ligne['quantite'] ?></td>
                <td><?= $ligne['tarif'] ?> FCFA</td>
                <td><?= $ligne['montant'] ?> FCFA</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Totaux -->
    <div class="text-end mb-3">
        <div>Total : <strong><?= $depot['montant_total'] ?> FCFA</strong></div>
        <div>Net à payer : <strong style="color:#1565c0;font-size:18px"><?= $depot['net_a_payer'] ?> FCFA</strong></div>
    </div>

    <!-- Boutons -->
    <div class="d-flex gap-2 justify-content-center">
        <a href="<?= APP_URL ?>/comptoir/reception" class="btn btn-primary">✦ Nouveau dépôt</a>
        <button onclick="window.print()" class="btn btn-secondary">🖨️ Imprimer</button>
    </div>
</div>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>