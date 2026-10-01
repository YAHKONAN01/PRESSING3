<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">

  <!-- BARRE DE FILTRE + TABLEAU IMPAYÉS -->
  <div class="card" style="border:1px solid #ccc; border-radius:4px; overflow:hidden; background:#fff; margin-bottom:15px;">
    <div style="background-color:#1a237e; color:#fff; padding:8px 15px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
      <div style="display:flex; align-items:center; gap:8px;">
        <span style="width:10px;height:10px;background:#f5c518;display:inline-block;"></span>
        <span style="font-weight:bold; font-size:13px; text-transform:uppercase;">RECOUVREMENTS CLIENTS</span>
      </div>

      <form method="GET" action="<?= APP_URL ?>/caisse/recouvrement" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin:0;">
        <span style="font-size:11px; color:#cbd5e1;">PÉRIODE DU</span>
        <input type="date" name="date_debut" value="<?= htmlspecialchars($debut ?? '') ?>" style="padding:4px 8px; border-radius:4px; border:1px solid #475569; font-size:12px;">
        <span style="font-size:11px; color:#cbd5e1;">AU</span>
        <input type="date" name="date_fin" value="<?= htmlspecialchars($fin ?? '') ?>" style="padding:4px 8px; border-radius:4px; border:1px solid #475569; font-size:12px;">
        <span style="font-size:11px; color:#cbd5e1;">CLIENT</span>
        <select name="client_id" style="padding:4px 8px; border-radius:4px; border:1px solid #475569; font-size:12px;">
          <option value="">Tous les clients</option>
          <?php foreach ($clients as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $clientId == $c['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['nom_prenoms']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button type="submit" style="background:#eab308; border:none; padding:5px 12px; border-radius:4px; font-weight:bold; font-size:12px; cursor:pointer;">
          🔄 Actualiser
        </button>
      </form>
    </div>

    <div class="table-responsive">
      <table style="width:100%; border-collapse:collapse; font-size:12.5px;">
        <thead>
          <tr style="background-color:#000;color:#facc15;text-transform:uppercase;font-size:11px;">
            <th style="padding:10px 15px;">Client</th>
            <th style="padding:10px 15px;">Téléphone</th>
            <th style="padding:10px 15px;">Déposé le</th>
            <th style="padding:10px 15px;">Référence</th>
            <th style="padding:10px 15px;text-align:right;">Mont. facture</th>
            <th style="padding:10px 15px;text-align:right;">Total payé</th>
            <th style="padding:10px 15px;text-align:right;">Reste à payer</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($impayes)): ?>
          <tr>
            <td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;font-style:italic;">
              Aucun impayé sur cette période. 🎉
            </td>
          </tr>
          <?php else: ?>
            <?php foreach ($impayes as $depot): ?>
            <tr onclick="window.location='<?= APP_URL ?>/caisse/recouvrement?depot_id=<?= $depot['id'] ?>'"
                style="border-bottom:1px solid #e2e8f0; cursor:pointer; <?= ($depotSelectionne && $depotSelectionne['id']==$depot['id']) ? 'background:#e8eaf6;' : '' ?>">
              <td style="padding:10px 15px;font-weight:600;"><?= htmlspecialchars($depot['client_nom']) ?></td>
              <td style="padding:10px 15px;"><?= htmlspecialchars($depot['client_telephone']) ?></td>
              <td style="padding:10px 15px;"><?= date('d/m/Y', strtotime($depot['date_depot'])) ?></td>
              <td style="padding:10px 15px;color:#dc2626;font-weight:600;"><?= htmlspecialchars($depot['code_depot']) ?></td>
              <td style="padding:10px 15px;text-align:right;"><?= number_format($depot['montant_total'],0,',',' ') ?> F</td>
              <td style="padding:10px 15px;text-align:right;color:#16a34a;"><?= number_format($depot['montant_paye'],0,',',' ') ?> F</td>
              <td style="padding:10px 15px;text-align:right;color:#dc2626;font-weight:bold;"><?= number_format($depot['reste_a_payer'],0,',',' ') ?> F</td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ARTICLES + FORMULAIRE CLIENT -->
  <div style="display:grid; grid-template-columns:1fr 350px; gap:15px;">

    <!-- ARTICLES DE LA COMMANDE -->
    <div class="card" style="border:1px solid #ccc; border-radius:4px; overflow:hidden; background:#fff;">
      <div style="background-color:#1a237e; color:#fff; padding:8px 15px; font-weight:bold; font-size:13px; text-transform:uppercase;">
        Articles de la commande sélectionnée
      </div>
      <table style="width:100%; border-collapse:collapse; font-size:12.5px;">
        <thead>
          <tr style="background-color:#000;color:#facc15;text-transform:uppercase;font-size:11px;">
            <th style="padding:10px 15px;">Désignation</th>
            <th style="padding:10px 15px;text-align:center;">Qté</th>
            <th style="padding:10px 15px;text-align:right;">Prix unitaire</th>
            <th style="padding:10px 15px;text-align:right;">Montant</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($depotSelectionne)): ?>
          <tr><td colspan="4" style="text-align:center;padding:40px;color:#94a3b8;font-style:italic;">
            Sélectionnez un client
          </td></tr>
          <?php elseif (empty($lignes)): ?>
          <tr><td colspan="4" style="text-align:center;padding:40px;color:#94a3b8;font-style:italic;">
            Aucun article pour ce dépôt.
          </td></tr>
          <?php else: ?>
            <?php foreach ($lignes as $l): ?>
            <tr style="border-bottom:1px solid #e2e8f0;">
              <td style="padding:10px 15px;"><?= htmlspecialchars($l['designation']) ?></td>
              <td style="padding:10px 15px;text-align:center;"><?= $l['quantite'] ?></td>
              <td style="padding:10px 15px;text-align:right;"><?= number_format($l['tarif'],0,',',' ') ?> F</td>
              <td style="padding:10px 15px;text-align:right;font-weight:bold;"><?= number_format($l['montant'],0,',',' ') ?> F</td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- FORMULAIRE CLIENT -->
    <div class="card" style="border:1px solid #ccc; border-radius:4px; overflow:hidden; background:#fff;">
      <div style="background-color:#1a237e; color:#fff; padding:8px 15px; font-weight:bold; font-size:13px; text-transform:uppercase; text-align:center;">
        Client
      </div>

      <?php if ($depotSelectionne): ?>
      <form method="POST" action="<?= APP_URL ?>/caisse/recouvrement/payer" style="padding:15px;">
        <input type="hidden" name="id" value="<?= $depotSelectionne['id'] ?>">

        <div style="display:flex; gap:15px; margin-bottom:15px; font-size:12px;">
          <label><input type="radio" name="type" value="paiement" checked> Paiement</label>
          <label><input type="radio" name="type" value="retrait"> Retrait</label>
          <label><input type="radio" name="type" value="les_deux"> Retrait+Paiement</label>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:12px;">
          <div>
            <label style="display:block;font-size:11px;font-weight:bold;color:#333;margin-bottom:4px;">MONTANT À PAYER</label>
            <input type="number" name="montant" value="<?= $depotSelectionne['reste_a_payer'] ?>" 
                   max="<?= $depotSelectionne['reste_a_payer'] ?>" min="0"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; text-align:center; font-weight:bold;">
          </div>
          <div>
            <label style="display:block;font-size:11px;font-weight:bold;color:#333;margin-bottom:4px;">DÉJÀ PAYÉ</label>
            <input type="text" value="<?= number_format($depotSelectionne['montant_paye'],0,',',' ') ?>" readonly
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; text-align:center; background:#e8f5e9; color:#16a34a; font-weight:bold;">
          </div>
        </div>

        <div style="margin-bottom:12px;">
          <label style="display:block;font-size:11px;font-weight:bold;color:#333;margin-bottom:4px;">MODE RÈGLEMENT</label>
          <select name="mode_reglement" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            <option value="">--</option>
            <option value="especes">Espèces</option>
            <option value="mobile_money">Mobile Money</option>
            <option value="cheque">Chèque</option>
            <option value="virement">Virement</option>
          </select>
        </div>

        <div style="margin-bottom:12px;">
          <label style="display:block;font-size:11px;font-weight:bold;color:#333;margin-bottom:4px;">RÉFÉRENCE PAIEMENT</label>
          <input type="text" name="reference_paiement" placeholder="Référence paiement"
                 style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <div style="margin-bottom:15px;">
          <input type="date" value="<?= date('Y-m-d') ?>" disabled
                 style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; background:#f1f5f9;">
        </div>

        <div style="display:flex; gap:8px;">
          <button type="button" onclick="window.location='<?= APP_URL ?>/caisse/recouvrement'"
                  style="flex:1; padding:10px; background:#fbbf24; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">
            + Nouveau
          </button>
          <button type="submit"
                  style="flex:1; padding:10px; background:#2563eb; color:#fff; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">
            ✔ Enregistrer
          </button>
        </div>
      </form>
      <?php else: ?>
        <div style="padding:40px 15px; text-align:center; color:#94a3b8; font-style:italic;">
          Sélectionnez un client dans la liste ci-dessus.
        </div>
      <?php endif; ?>
    </div>

  </div>

</div>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>