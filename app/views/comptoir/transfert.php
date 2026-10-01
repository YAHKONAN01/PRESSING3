<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">
  <div class="d-flex justify-content-between align-items-center mb-3 bg-primary text-white p-2 rounded" style="background-color: #1a237e !important;">
    <h6 class="fw-bold m-0">↑ DÉPÔT — TRANSFERT DES VÊTEMENTS EN SALLE DE TRAITEMENT</h6>
  </div>

  <form method="POST" action="<?= APP_URL ?>/comptoir/transfert/save" id="fTransfert">
    <input type="hidden" name="ids" id="fIds">

    <div class="row g-2 align-items-center mb-3 p-2 border rounded bg-light">
      <div class="col-auto">
        <label for="machiniste" class="col-form-label fw-bold small">Machiniste</label>
      </div>
      <div class="col-md-3">
        <input type="text" name="machiniste" id="machiniste" class="form-control form-control-sm" placeholder="Nom du machiniste" required>
      </div>
      
      <div class="col-auto ms-3">
        <label for="date_transfert" class="col-form-label fw-bold small">Date transfert</label>
      </div>
      <div class="col-md-2">
        <input type="date" name="date_transfert" id="date_transfert" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>">
      </div>

      <div class="col-auto ms-auto">
        <button type="button" class="btn btn-warning btn-sm fw-bold px-3" onclick="window.location.reload()">↺ Actualiser</button>
      </div>
    </div>

    <table class="table table-bordered table-hover table-sm align-middle mb-3">
      <thead class="table-dark" style="background-color: #000000;">
        <tr class="text-warning small text-uppercase">
          <th style="width:40px" class="text-center">
            <input type="checkbox" id="chkMaster" onchange="toggleAll(this)">
          </th>
          <th>Date Dépôt</th>
          <th>Désignation</th>
          <th class="text-center" style="width: 80px;">Qté</th>
          <th>Observation</th>
          <th class="text-center" style="width: 120px;">Transférer</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($lignes as $l): ?>
        <tr>
          <td class="text-center bg-light">
            <small class="text-muted">#<?= $l['id'] ?></small>
          </td>
          <td style="font-size:12px;">
            <?= date('d/m/Y', strtotime($l['date_depot'])) ?><br>
            <span class="text-primary fw-bold" style="font-size:11px;"><?= htmlspecialchars($l['code_depot']) ?></span> - 
            <span class="text-secondary" style="font-size:11px;"><?= htmlspecialchars($l['client_nom']) ?></span>
          </td>
          <td class="fw-bold text-secondary"><?= htmlspecialchars($l['designation']) ?></td>
          <td class="text-center fw-bold"><?= htmlspecialchars($l['quantite']) ?></td>
          <td class="text-muted small"><?= htmlspecialchars($l['observation'] ?? '') ?></td>
          <td class="text-center">
            <input type="checkbox" class="chk-ligne" value="<?= (int)$l['id'] ?>">
          </td>
        </tr>
        <?php endforeach; ?>
        
        <?php if(empty($lignes)): ?>
        <tr>
          <td colspan="6" class="text-center text-muted py-4 small">
            Aucun article en attente de transfert.
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <button type="button" class="btn btn-primary fw-bold btn-sm shadow-sm" onclick="valider()">
      ✓ Enregistrer le transfert
    </button>
  </form>
</div>

<script>
// Fonction pour cocher/décocher toutes les lignes via la case d'en-tête à gauche
function toggleAll(masterCheckbox) {
  document.querySelectorAll('.chk-ligne').forEach(checkbox => {
    checkbox.checked = masterCheckbox.checked;
  });
}

// Validation et envoi du formulaire
function valider() {
  const machiniste = document.getElementById('machiniste').value.trim();
  if (!machiniste) {
    alert('Veuillez renseigner le nom du machiniste avant de valider.');
    document.getElementById('machiniste').focus();
    return;
  }

  // Récupère les cases cochées dans la colonne "Transférer" (à droite)
  const ids = Array.from(document.querySelectorAll('.chk-ligne:checked')).map(c => c.value);
  
  if (!ids.length) { 
    alert('Veuillez cocher au moins un article à transférer dans la colonne de droite.'); 
    return; 
  }
  
  // Remplissage du champ caché et soumission
  document.getElementById('fIds').value = JSON.stringify(ids);
  document.getElementById('fTransfert').submit();
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>