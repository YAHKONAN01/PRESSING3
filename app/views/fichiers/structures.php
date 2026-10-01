<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">

  <!-- TABLEAU LISTE -->
  <div style="max-height:300px;overflow:auto;margin-bottom:10px">
    <table class="table table-bordered table-hover table-sm">
      <thead class="table-dark">
        <tr>
          <th>LIBELLÉ</th>
          <th>VILLE</th>
          <th>TÉLÉPHONE</th>
          <th>GÉRANT</th>
          <th style="width:100px">TYPE</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($structures as $s): ?>
        <tr onclick="remplirForm(<?= htmlspecialchars(json_encode($s)) ?>)"
            style="cursor:pointer">
          <td style="font-weight:600"><?= htmlspecialchars($s['libelle']) ?></td>
          <td><?= htmlspecialchars($s['ville']) ?></td>
          <td><?= htmlspecialchars($s['telephone']) ?></td>
          <td><?= htmlspecialchars($s['gerant']) ?></td>
          <td><?= htmlspecialchars($s['type']) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($structures)): ?>
        <tr><td colspan="5" style="text-align:center;color:#9e9e9e;padding:20px">
          Aucune structure définie.
        </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- FORMULAIRE BAS -->
  <div style="border-top:2px solid #e0e0e0;padding-top:12px">
    <form method="POST" action="<?= APP_URL ?>/fichiers/structure/save" id="fStruct">
      <input type="hidden" name="id" id="sId">

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">
        <div>
          <label class="fw-bold" style="font-size:12px">Libellé *</label>
          <input type="text" name="libelle" id="sLibelle"
                 class="form-control form-control-sm" required
                 placeholder="Ex: Pressing Centre-ville">
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Ville</label>
          <input type="text" name="ville" id="sVille"
                 class="form-control form-control-sm">
        </div>
      </div>

      <div style="margin-bottom:10px">
        <label class="fw-bold" style="font-size:12px">Situation géographique</label>
        <input type="text" name="situation_geo" id="sGeo"
               class="form-control form-control-sm"
               placeholder="Ex: Quartier, repère...">
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">
        <div>
          <label class="fw-bold" style="font-size:12px">Téléphone</label>
          <input type="text" name="telephone" id="sTel"
                 class="form-control form-control-sm">
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Email</label>
          <input type="email" name="email" id="sEmail"
                 class="form-control form-control-sm">
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">
        <div>
          <label class="fw-bold" style="font-size:12px">Gérant</label>
          <input type="text" name="gerant" id="sGerant"
                 class="form-control form-control-sm">
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Type</label>
          <select name="type" id="sType" class="form-select form-select-sm">
            <option value="Pressing">Pressing</option>
            <option value="Dépôt">Dépôt</option>
            <option value="Siège">Siège</option>
          </select>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">
        <div>
          <label class="fw-bold" style="font-size:12px">Pressing (référence)</label>
          <input type="text" name="pressing" id="sPressing"
                 class="form-control form-control-sm">
        </div>
        <div style="display:flex;align-items:center;gap:5px;padding-bottom:4px">
          <input type="checkbox" name="magasin_depot" id="sDepot" value="1">
          <label class="fw-bold" style="font-size:12px">Magasin dépôt</label>
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
          action="<?= APP_URL ?>/fichiers/structure/delete" style="display:none">
      <input type="hidden" name="id" id="sDelId">
    </form>
  </div>
</div>

<script>
function remplirForm(s) {
  document.getElementById('sId').value        = s.id;
  document.getElementById('sLibelle').value   = s.libelle;
  document.getElementById('sVille').value     = s.ville;
  document.getElementById('sGeo').value       = s.situation_geo;
  document.getElementById('sTel').value       = s.telephone;
  document.getElementById('sEmail').value     = s.email;
  document.getElementById('sGerant').value    = s.gerant;
  document.getElementById('sType').value      = s.type;
  document.getElementById('sPressing').value  = s.pressing;
  document.getElementById('sDepot').checked   = s.magasin_depot == '1';
}

function nouveauForm() {
  document.getElementById('fStruct').reset();
  document.getElementById('sId').value = '';
}

function supprimer() {
  const id = document.getElementById('sId').value;
  if (!id) { alert('Sélectionnez une structure dans la liste.'); return; }
  if (!confirm('Supprimer cette structure ?')) return;
  document.getElementById('sDelId').value = id;
  document.getElementById('fDel').submit();
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>