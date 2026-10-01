<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">

  <!-- TABLEAU LISTE -->
  <div style="max-height:350px;overflow:auto;margin-bottom:10px">
    <table class="table table-bordered table-hover table-sm">
      <thead class="table-dark">
        <tr>
          <th>LIBELLÉ</th>
          <th style="width:120px">SENS</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($lignes_caisse as $l): ?>
        <tr onclick="remplirForm(<?= htmlspecialchars(json_encode($l)) ?>)"
            style="cursor:pointer">
          <td style="font-weight:600"><?= htmlspecialchars($l['libelle']) ?></td>
          <td style="text-align:center">
            <?php if($l['sens'] === 'Entrée'): ?>
              <span class="badge bg-success">↓ Entrée</span>
            <?php else: ?>
              <span class="badge bg-danger">↑ Sortie</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($lignes_caisse)): ?>
        <tr><td colspan="2" style="text-align:center;color:#9e9e9e;padding:20px">
          Aucune ligne de caisse définie.
        </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- FORMULAIRE BAS -->
  <div style="border-top:2px solid #e0e0e0;padding-top:12px">
    <form method="POST" action="<?= APP_URL ?>/fichiers/lignes_caisse/save" id="fLigne">
      <input type="hidden" name="id" id="lId">
      <div style="display:grid;grid-template-columns:1fr 150px;gap:10px;align-items:end;margin-bottom:10px">
        <div>
          <label class="fw-bold" style="font-size:12px">Libellé *</label>
          <input type="text" name="libelle" id="lLibelle"
                 class="form-control form-control-sm" required
                 placeholder="Ex: Vente comptoir, Achat produits...">
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Sens *</label>
          <select name="sens" id="lSens" class="form-select form-select-sm" required>
            <option value="Entrée">Entrée</option>
            <option value="Sortie">Sortie</option>
          </select>
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
          action="<?= APP_URL ?>/fichiers/lignes_caisse/delete" style="display:none">
      <input type="hidden" name="id" id="lDelId">
    </form>
  </div>
</div>

<script>
function remplirForm(l) {
  document.getElementById('lId').value      = l.id;
  document.getElementById('lLibelle').value = l.libelle;
  document.getElementById('lSens').value    = l.sens;
}

function nouveauForm() {
  document.getElementById('fLigne').reset();
  document.getElementById('lId').value = '';
}

function supprimer() {
  const id = document.getElementById('lId').value;
  if (!id) { alert('Sélectionnez une ligne dans la liste.'); return; }
  if (!confirm('Supprimer cette ligne de caisse ?')) return;
  document.getElementById('lDelId').value = id;
  document.getElementById('fDel').submit();
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>