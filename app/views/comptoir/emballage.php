<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">
  <div class="d-flex justify-content-between align-items-center mb-3 text-white p-2 rounded" style="background-color: #1a237e !important;">
    <h6 class="fw-bold m-0">📦 DÉPÔT — MISE SOUS EMBALLAGE</h6>
    <button class="btn btn-warning btn-sm fw-bold px-3" onclick="window.location.reload()">↺ Actualiser</button>
  </div>

  <form method="POST" action="<?= APP_URL ?>/comptoir/emballage/save" id="fEmb">
    <input type="hidden" name="ids" id="fIds">

    <table class="table table-bordered table-hover table-sm align-middle mb-3">
      <thead class="table-dark" style="background-color: #000000;">
        <tr class="text-warning small text-uppercase">
          <th style="width:40px" class="text-center">
            <input type="checkbox" id="chkMaster" onchange="toggleAll(this)">
          </th>
          <th>DATE DÉPÔT / CODE</th>
          <th>DESIGNATION / VÊTEMENT</th>
          <th class="text-center" style="width: 80px;">QTÉ</th>
          <th>OBSERVATION</th>
          <th class="text-center" style="width: 120px;">EMBALLÉ 📦</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($lignes as $l): ?>
        <tr>
          <td class="text-center bg-light">
            <small class="text-muted">#<?= (int)$l['id'] ?></small>
          </td>
          <td style="font-size:12px;">
            <strong class="text-dark"><?= date('d/m/Y', strtotime($l['date_depot'])) ?></strong><br>
            <span class="text-primary fw-bold" style="font-size:11px;"><?= htmlspecialchars($l['code_depot']) ?></span> - 
            <span class="text-secondary" style="font-size:11px;"><?= htmlspecialchars($l['client_nom']) ?></span>
          </td>
          <td class="fw-bold text-secondary"><?= htmlspecialchars($l['designation']) ?></td>
          <td class="text-center fw-bold text-dark"><?= htmlspecialchars($l['quantite']) ?></td>
          <td class="text-muted small"><?= htmlspecialchars($l['observation'] ?? '') ?></td>
          <td class="text-center">
            <input type="checkbox" class="chk-ligne" value="<?= (int)$l['id'] ?>">
          </td>
        </tr>
        <?php endforeach; ?>
        
        <?php if(empty($lignes)): ?>
        <tr>
          <td colspan="6" class="text-center text-muted py-4 small">
            Aucun article en attente d'emballage.
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <button type="button" class="btn btn-primary fw-bold btn-sm shadow-sm" onclick="valider()">
      📦 Enregistrer la mise sous emballage
    </button>
  </form>
</div>

<script>
// Permet à la case de gauche de tout cocher à droite
function toggleAll(masterCheckbox) {
  document.querySelectorAll('.chk-ligne').forEach(checkbox => {
    checkbox.checked = masterCheckbox.checked;
  });
}

// Extraction des données cochées et soumission sécurisée
function valider() {
  const ids = Array.from(document.querySelectorAll('.chk-ligne:checked')).map(c => c.value);
  
  if (!ids.length) { 
    alert('Veuillez cocher au moins un vêtement dans la colonne "EMBALLÉ 📦" avant de valider.'); 
    return; 
  }
  
  if (confirm('Confirmer la mise sous emballage de ces ' + ids.length + ' article(s) ?')) {
    document.getElementById('fIds').value = JSON.stringify(ids);
    document.getElementById('fEmb').submit();
  }
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>