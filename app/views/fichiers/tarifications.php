<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">

  <!-- TABLEAU LISTE -->
  <div style="max-height:350px;overflow:auto;margin-bottom:10px">
    <table class="table table-bordered table-hover table-sm">
      <thead class="table-dark">
        <tr>
          <th>VÊTEMENT</th>
          <th>TRAITEMENT</th>
          <th style="width:120px">TARIF</th>
          <th style="width:100px">PROMO</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tarifications as $tf): ?>
        <tr onclick="remplirForm(<?= htmlspecialchars(json_encode($tf)) ?>)"
            style="cursor:pointer">
          <td><?= htmlspecialchars($tf['vetement']) ?></td>
          <td><?= htmlspecialchars($tf['traitement']) ?></td>
          <td style="text-align:right;color:#1565c0;font-weight:700">
            <?= number_format($tf['tarif'],0,',',' ') ?> FCFA
          </td>
          <td style="text-align:center">
            <?= $tf['promotion'] ? number_format($tf['promotion'],0,',',' ').' FCFA' : '-' ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($tarifications)): ?>
        <tr><td colspan="4" style="text-align:center;color:#9e9e9e;padding:20px">
          Aucune tarification définie.
        </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- FORMULAIRE BAS -->
  <div style="border-top:2px solid #e0e0e0;padding-top:12px">
    <form method="POST" action="<?= APP_URL ?>/fichiers/tarifications/save" id="fTarif">
      <input type="hidden" name="id" id="tfId">
      <div style="display:grid;grid-template-columns:1fr 1fr 120px 120px;gap:10px;align-items:end;margin-bottom:10px">
        <div>
          <label class="fw-bold" style="font-size:12px">Vêtement *</label>
          <select name="type_vetement_id" id="tfVetement" class="form-select form-select-sm" required>
            <option value="">-- Choisir --</option>
            <?php foreach($vetements as $v): ?>
              <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['libelle']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Traitement *</label>
          <select name="type_traitement_id" id="tfTraitement" class="form-select form-select-sm" required>
            <option value="">-- Choisir --</option>
            <?php foreach($traitements as $t): ?>
              <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['traitement']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Tarif *</label>
          <input type="number" name="tarif" id="tfTarif"
                 class="form-control form-control-sm" value="0" min="0" required>
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Promotion</label>
          <input type="number" name="promotion" id="tfPromo"
                 class="form-control form-control-sm" value="0" min="0">
        </div>
      </div>
      <div style="display:flex;gap:8px">
        <button type="button" class="btn btn-warning btn-sm fw-bold"
                onclick="nouveauForm()">✦ Nouveau</button>
        <button type="submit" class="btn btn-primary btn-sm fw-bold">✔ Enregistrer</button>
        <button type="button" class="btn btn-danger btn-sm fw-bold"
                onclick="supprimer()">🗑 Supprimer</button>
      </div>
    </form>

    <form id="fDel" method="POST"
          action="<?= APP_URL ?>/fichiers/tarifications/delete" style="display:none">
      <input type="hidden" name="id" id="tfDelId">
    </form>
  </div>
</div>

<script>
function remplirForm(tf) {
  document.getElementById('tfId').value          = tf.id;
  document.getElementById('tfVetement').value    = tf.type_vetement_id;
  document.getElementById('tfTraitement').value  = tf.type_traitement_id;
  document.getElementById('tfTarif').value       = tf.tarif;
  document.getElementById('tfPromo').value       = tf.promotion;
}

function nouveauForm() {
  document.getElementById('fTarif').reset();
  document.getElementById('tfId').value = '';
}

function supprimer() {
  const id = document.getElementById('tfId').value;
  if (!id) { alert('Sélectionnez une tarification dans la liste.'); return; }
  if (!confirm('Supprimer cette tarification ?')) return;
  document.getElementById('tfDelId').value = id;
  document.getElementById('fDel').submit();
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>