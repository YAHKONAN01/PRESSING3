<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-2">
  
  <div class="card mb-3 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-1" style="background-color: #1a237e !important;">
      <h6 class="fw-bold m-0 text-uppercase small" style="letter-spacing: 0.5px;">Liste des retraits</h6>
      <button class="btn btn-warning btn-xs fw-bold py-0 px-2 small" onclick="window.location.reload()" style="font-size: 11px;">↺ Actualiser</button>
    </div>
    <div class="card-body p-0" style="max-height: 200px; overflow-y: auto;">
      <table class="table table-bordered table-hover table-sm align-middle mb-0 text-center" id="tableRetraits" style="font-size: 12px;">
        <thead class="table-dark">
          <tr class="text-warning small">
            <th>CLIENT</th>
            <th>TÉLÉPHONE</th>
            <th>DÉPOSÉ LE</th>
            <th>RÉFÉRENCE</th>
            <th>RESTE À PAYER</th>
            <th>RDV FIXÉ</th>
            <th>MODE RETRAIT</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($retraitsEnAttente)): ?>
            <?php foreach($retraitsEnAttente as $r): ?>
              <tr class="curseur-pointer" 
                  onclick="chargerDepot(<?= $r['id'] ?>, '<?= addslashes($r['client_nom']) ?>', '<?= $r['reste_a_payer'] ?>')" 
                  id="row-<?= $r['id'] ?>">
                <td class="fw-bold text-start ps-2"><?= htmlspecialchars($r['client_nom']) ?></td>
                <td><?= htmlspecialchars($r['client_telephone']) ?></td>
                <td><?= date('d/m/Y', strtotime($r['date_depot'])) ?></td>
                <td class="text-danger fw-bold"><?= htmlspecialchars($r['code_depot']) ?></td>
                <td class="text-danger fw-bold"><?= number_format($r['reste_a_payer'], 0, ',', ' ') ?> F</td>
                <td><?= $r['date_retrait'] ? date('d/m/Y', strtotime($r['date_retrait'])) : '-' ?></td>
                <td><?= htmlspecialchars($r['mode_retrait']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-muted py-3">Aucun retrait en attente.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row g-2">
    
    <div class="col-md-8">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-primary text-white py-1" style="background-color: #1a237e !important;">
          <h6 class="fw-bold m-0 text-uppercase small" style="letter-spacing: 0.5px;">Articles du dépôt sélectionné</h6>
        </div>
        <div class="card-body p-0 bg-white d-flex flex-column" style="min-height: 250px;">
          <table class="table table-bordered table-sm align-middle text-center mb-0" style="font-size: 12px;" id="tableArticles">
            <thead class="table-dark">
              <tr class="text-warning small">
                <th class="text-start ps-2">DÉSIGNATION</th>
                <th style="width: 70px;">QTÉ</th>
                <th>OBSERVATION</th>
                <th style="width: 100px;">TRAITÉ ?</th>
                <th style="width: 100px;">EMBALLÉ ?</th>
              </tr>
            </thead>
            <tbody id="bodyArticles">
              <tr>
                <td colspan="5" class="text-muted py-5 text-center" id="placeholderArticles">Sélectionnez un client ci-dessus</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-primary">
        <div class="card-header bg-primary text-white text-center py-1 fw-bold small" style="background-color: #1a237e !important; letter-spacing: 0.5px;">
          CLIENT
        </div>
        <div class="card-body bg-light p-2">
          <form method="POST" action="<?= APP_URL ?>/retrait/save" id="formRetrait">
            <input type="hidden" name="depot_id" id="inputDepotId">

            <div class="d-flex justify-content-between mb-2 p-1 bg-white border rounded" style="font-size: 11px;">
              <div class="form-check form-check-inline m-0">
                <input class="form-check-input" type="radio" name="type_action" id="actRetraitPaiement" value="retrait_paiement" checked onchange="ajusterChamps()">
                <label class="form-check-label fw-bold text-danger" for="actRetraitPaiement">RETRAIT+PAIEMENT</label>
              </div>
              <div class="form-check form-check-inline m-0">
                <input class="form-check-input" type="radio" name="type_action" id="actRetrait" value="retrait_seul" onchange="ajusterChamps()">
                <label class="form-check-label fw-bold text-primary" for="actRetrait">RETRAIT</label>
              </div>
              <div class="form-check form-check-inline m-0">
                <input class="form-check-input" type="radio" name="type_action" id="actPaiement" value="paiement_seul" onchange="ajusterChamps()">
                <label class="form-check-label fw-bold text-success" for="actPaiement">PAIEMENT</label>
              </div>
            </div>

            <div class="row g-2 mb-2">
              <div class="col-6">
                <label class="fw-bold small text-muted text-uppercase" style="font-size: 10px;">Montant à payer</label>
                <input type="text" id="montantAPayer" class="form-control form-control-sm text-center fw-bold bg-white" readonly value="0" style="font-size: 14px;">
              </div>
              <div class="col-6">
                <label class="fw-bold small text-muted text-uppercase" style="font-size: 10px;">Montant Payé</label>
                <input type="number" name="montant_paye" id="montantPaye" class="form-control form-control-sm text-center fw-bold text-success" value="0" style="font-size: 14px; background-color: #e8f5e9;" min="0">
              </div>
            </div>

            <div class="mb-2">
              <select name="mode_reglement" id="modeReglement" class="form-select form-select-sm" style="font-size: 12px;" required>
                <option value="">-- Mode de règlement --</option>
                <option value="Espèces">Espèces</option>
                <option value="Mobile Money">Mobile Money (Orange/MTN/Wave)</option>
                <option value="Chèque">Chèque</option>
              </select>
            </div>

            <div class="mb-2">
              <input type="text" name="reference_paiement" id="referencePaiement" class="form-control form-control-sm" placeholder="Référence paiement" style="font-size: 12px;">
            </div>

            <div class="mb-2">
              <label class="fw-bold text-muted text-uppercase m-0" style="font-size: 10px;">Retiré par</label>
              <input type="text" name="retire_par" id="retirePar" class="form-control form-control-sm" placeholder="Nom" style="font-size: 12px;" required>
            </div>

            <div class="mb-3">
              <label class="fw-bold text-muted text-uppercase m-0" style="font-size: 10px;">Date</label>
              <input type="date" name="date_action" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" style="font-size: 12px;">
            </div>

            <div class="row g-2">
              <div class="col-5">
                <button type="button" class="btn btn-warning btn-sm w-100 fw-bold shadow-sm" onclick="reinitialiserFormulaire()">+ Nouveau</button>
              </div>
              <div class="col-7">
                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold shadow-sm">✓ Enregistrer</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<style>
  .curseur-pointer { cursor: pointer; }
  .ligne-selectionnee { background-color: #ffe082 !important; }
</style>

<script>
// CORRECTION : La fonction accepte désormais des arguments simples au lieu d'un objet JSON complexe
function chargerDepot(id, clientNom, resteAPayer) {
  // 1. Gérer l'état graphique des lignes
  document.querySelectorAll('#tableRetraits tbody tr').forEach(tr => tr.classList.remove('ligne-selectionnee'));
  document.getElementById('row-' + id).classList.add('ligne-selectionnee');

  // 2. Remplir le formulaire de droite automatiquement
  document.getElementById('inputDepotId').value = id;
  document.getElementById('montantAPayer').value = resteAPayer;
  document.getElementById('montantPaye').value = resteAPayer;
  document.getElementById('retirePar').value = clientNom;

  ajusterChamps();

  // 3. Charger les lignes d'articles via Fetch AJAX
  const body = document.getElementById('bodyArticles');
  body.innerHTML = `<tr><td colspan="5" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div> Chargement des articles...</td></tr>`;

  fetch(`<?= APP_URL ?>/retrait/getLignes?depot_id=${id}`)
    .then(res => res.json())
    .then(lignes => {
      body.innerHTML = '';
      if(lignes.length === 0) {
        body.innerHTML = `<tr><td colspan="5" class="text-muted py-4">Aucun article trouvé.</td></tr>`;
        return;
      }
      lignes.forEach(l => {
        const traite = l.statut_traitement === 'traite' || l.statut_traitement === 'emballe' || l.statut_traitement === 'livre' ? '✔' : '';
        const emballe = l.statut_traitement === 'emballe' || l.statut_traitement === 'livre' ? '✔' : '';
        
        body.innerHTML += `
          <tr>
            <td class="text-start ps-2 fw-bold text-secondary">${l.designation} <span class="text-muted font-monospace" style="font-size:10px;">(${l.service})</span></td>
            <td class="fw-bold">${l.quantite}</td>
            <td class="text-muted text-start ps-2">${l.observation || ''}</td>
            <td class="text-success fw-bold">${traite}</td>
            <td class="text-success fw-bold">${emballe}</td>
          </tr>
        `;
      });
    })
    .catch(() => {
      body.innerHTML = `<tr><td colspan="5" class="text-danger py-4">Erreur lors du chargement des articles.</td></tr>`;
    });
}

function ajusterChamps() {
  const action = document.querySelector('input[name="type_action"]:checked').value;
  const montantPaye = document.getElementById('montantPaye');
  const modeReglement = document.getElementById('modeReglement');
  const referencePaiement = document.getElementById('referencePaiement');
  const retirePar = document.getElementById('retirePar');

  if (action === 'retrait_seul') {
    montantPaye.value = 0;
    montantPaye.disabled = true;
    modeReglement.disabled = true;
    modeReglement.required = false;
    referencePaiement.disabled = true;
    retirePar.disabled = false;
    retirePar.required = true;
  } else if (action === 'paiement_seul') {
    montantPaye.disabled = false;
    modeReglement.disabled = false;
    modeReglement.required = true;
    referencePaiement.disabled = false;
    retirePar.disabled = true;
    retirePar.required = false;
  } else {
    montantPaye.disabled = false;
    modeReglement.disabled = false;
    modeReglement.required = true;
    referencePaiement.disabled = false;
    retirePar.disabled = false;
    retirePar.required = true;
  }
}

function reinitialiserFormulaire() {
  document.getElementById('formRetrait').reset();
  document.getElementById('inputDepotId').value = '';
  document.getElementById('montantAPayer').value = '0';
  document.querySelectorAll('#tableRetraits tbody tr').forEach(tr => tr.classList.remove('ligne-selectionnee'));
  document.getElementById('bodyArticles').innerHTML = `<tr><td colspan="5" class="text-muted py-5 text-center">Sélectionnez un client ci-dessus</td></tr>`;
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>