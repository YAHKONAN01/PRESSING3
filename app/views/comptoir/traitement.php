<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">
  <div class="d-flex justify-content-between align-items-center mb-3 text-white p-2 rounded" style="background-color: #1a237e !important;">
    <h6 class="fw-bold m-0">✔ DÉPÔT — CONFIRMATION DES TRAITEMENTS</h6>
    <button class="btn btn-warning btn-sm fw-bold px-3" onclick="window.location.reload()">↺ Actualiser</button>
  </div>

  <form method="POST" action="<?= APP_URL ?>/comptoir/traitement/save" id="fTrait">
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
          <th class="text-center" style="width: 120px;">TRAITÉ ✓</th>
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
            Aucun article en attente de traitement en salle machine.
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <button type="button" class="btn btn-primary fw-bold btn-sm shadow-sm" onclick="valider()">
      ✔ Confirmer le traitement des articles cochés
    </button>
  </form>
</div>

<script>
// Coche ou décoche toutes les lignes via le master de gauche
function toggleAll(masterCheckbox) {
  document.querySelectorAll('.chk-ligne').forEach(checkbox => {
    checkbox.checked = masterCheckbox.checked;
  });
}

// Validation des données et envoi sécurisé en JSON
function valider() {
  const ids = Array.from(document.querySelectorAll('.chk-ligne:checked')).map(c => c.value);
  
  if (!ids.length) { 
    alert('Veuillez cocher au moins un vêtement dans la colonne "TRAITÉ ✓" avant de valider.'); 
    return; 
  }
  
  if (confirm('Confirmer le traitement de ces ' + ids.length + ' article(s) ?')) {
    document.getElementById('fIds').value = JSON.stringify(ids);
    document.getElementById('fTrait').submit();
  }
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>