<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">

  <!-- TABLEAU LISTE -->
  <div style="max-height:350px;overflow:auto;margin-bottom:10px">
    <table class="table table-bordered table-hover table-sm">
      <thead class="table-dark">
        <tr>
          <th style="width:50px">CODE</th>
          <th>TRAITEMENT</th>
          <th style="width:80px">QTÉ</th>
          <th style="width:120px">PRIX PACK</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($traitements as $t): ?>
        <tr onclick="remplirForm(<?= htmlspecialchars(json_encode($t)) ?>)" 
            style="cursor:pointer">
          <td style="text-align:center;color:#546e7a"><?= $t['id'] ?></td>
          <td style="font-weight:600"><?= htmlspecialchars($t['traitement']) ?></td>
          <td style="text-align:center"><?= $t['qte_pack'] ?></td>
          <td style="text-align:right;color:#1565c0;font-weight:700">
            <?= number_format($t['prix_pack'],0,',',' ') ?> FCFA
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($traitements)): ?>
        <tr><td colspan="4" style="text-align:center;color:#9e9e9e;padding:20px">
          Aucun traitement défini.
        </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- FORMULAIRE BAS -->
  <div style="border-top:2px solid #e0e0e0;padding-top:12px">
    <form method="POST" action="<?= APP_URL ?>/fichiers/traitements/save" id="fTrait">
      <input type="hidden" name="id" id="tId">
      <div style="display:grid;grid-template-columns:1fr 100px 120px;gap:10px;align-items:end;margin-bottom:10px">
        <div>
          <label class="fw-bold" style="font-size:12px">Traitement *</label>
          <input type="text" name="traitement" id="tTraitement" 
                 class="form-control form-control-sm" required 
                 placeholder="Ex: Lavage, Repassage, Pack 10...">
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Qté pack</label>
          <input type="number" name="qte_pack" id="tQte" 
                 class="form-control form-control-sm" value="0" min="0">
        </div>
        <div>
          <label class="fw-bold" style="font-size:12px">Prix pack (FCFA)</label>
          <input type="number" name="prix_pack" id="tPrix" 
                 class="form-control form-control-sm" value="0" min="0">
        </div>
      </div>
      <div style="display:flex;gap:8px">
        <button type="button" class="btn btn-warning btn-sm fw-bold" 
                onclick="nouveauForm()">✦ Nouveau</button>
        <button type="submit" class="btn btn-primary btn-sm fw-bold">✔ Valider</button>
        <button type="button" class="btn btn-danger btn-sm fw-bold" 
                onclick="supprimer()">🗑 Supprimer</button>
      </div>
    </form>

    <form id="fDel" method="POST" 
          action="<?= APP_URL ?>/fichiers/traitements/delete" style="display:none">
      <input type="hidden" name="id" id="tDelId">
    </form>
  </div>
</div>

<script>
function remplirForm(t) {
  document.getElementById('tId').value          = t.id;
  document.getElementById('tTraitement').value  = t.traitement;
  document.getElementById('tQte').value         = t.qte_pack;
  document.getElementById('tPrix').value        = t.prix_pack;
}

function nouveauForm() {
  document.getElementById('fTrait').reset();
  document.getElementById('tId').value = '';
}

function supprimer() {
  const id = document.getElementById('tId').value;
  if (!id) { alert('Sélectionnez un traitement dans la liste.'); return; }
  if (!confirm('Supprimer ce traitement ?')) return;
  document.getElementById('tDelId').value = id;
  document.getElementById('fDel').submit();
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>