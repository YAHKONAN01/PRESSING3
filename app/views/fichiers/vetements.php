<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">

  <div style="max-height:350px;overflow:auto;margin-bottom:10px">
    <table class="table table-bordered table-hover table-sm">
      <thead class="table-dark">
        <tr>
          <th>LIBELLÉ</th>
          <th style="width:120px">TARIF</th>
          <th style="width:100px">PACK</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($vetements as $v): ?>
        <tr onclick='remplirForm(<?= htmlspecialchars(json_encode($v), ENT_QUOTES, "UTF-8") ?>)'
            style="cursor:pointer">
          <td><?= htmlspecialchars($v['libelle']) ?></td>
          <td style="text-align:right;color:#1565c0;font-weight:700">
            <?= number_format($v['tarif'],0,',',' ') ?> FCFA
          </td>
          <td style="text-align:center"><?= $v['pack'] ? '✓' : '' ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($vetements)): ?>
        <tr><td colspan="3" style="text-align:center;color:#9e9e9e;padding:20px">
          Aucun vêtement défini.
        </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div style="border-top:2px solid #e0e0e0;padding-top:12px">
    <form method="POST" action="<?= APP_URL ?>/fichiers/vetements/save" id="fVet">
      <input type="hidden" name="id" id="vId">
      <div style="display:grid;grid-template-columns:1fr 130px auto;gap:10px;align-items:end;margin-bottom:8px">
        <div>
          <label class="fw-bold" style="font-size:12px">Type vêtement *</label>
          <input type="text" name="libelle" id="vLibelle"
                 class="form-control form-control-sm" required
                 placeholder="Ex: Chemise, Pantalon, Boubou...">
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Tarif *</label>
          <input type="number" name="tarif" id="vTarif"
                 class="form-control form-control-sm" value="0" min="0">
        </div>
        <div style="display:flex;align-items:center;gap:5px;padding-bottom:4px">
          <input type="checkbox" name="pack" id="vPack" value="1">
          <label class="fw-bold" style="font-size:12px">Pack</label>
        </div>
      </div>
      <div style="margin-bottom:10px">
        <label class="fw-bold" style="font-size:12px">Description</label>
        <textarea name="description" id="vDesc"
                  class="form-control form-control-sm" rows="2"></textarea>
      </div>
      <div style="display:flex;gap:8px">
        <button type="button" class="btn btn-warning btn-sm fw-bold"
                onclick="nouveauForm()">✦ Nouveau +</button>
        <button type="submit" class="btn btn-primary btn-sm fw-bold">✔ Enregistrer</button>
        <button type="button" class="btn btn-danger btn-sm fw-bold"
                onclick="supprimer()">🗑 Supprimer</button>
      </div>
    </form>

    <form id="fDel" method="POST"
          action="<?= APP_URL ?>/fichiers/vetements/delete" style="display:none">
      <input type="hidden" name="id" id="vDelId">
    </form>
  </div>
</div>

<script>
function remplirForm(v) {
  document.getElementById('vId').value      = v.id;
  document.getElementById('vLibelle').value = v.libelle;
  document.getElementById('vTarif').value   = v.tarif;
  document.getElementById('vDesc').value    = v.description || '';
  // CORRECTION ICI : Conversion en entier pour éviter les conflits de types
  document.getElementById('vPack').checked  = parseInt(v.pack) === 1;
}

function nouveauForm() {
  document.getElementById('fVet').reset();
  document.getElementById('vId').value = '';
}

function supprimer() {
  const id = document.getElementById('vId').value;
  if (!id) { alert('Sélectionnez un vêtement dans la liste.'); return; }
  if (!confirm('Supprimer ce vêtement ?')) return;
  document.getElementById('vDelId').value = id;
  document.getElementById('fDel').submit();
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>