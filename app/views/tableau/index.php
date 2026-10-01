<?php $pageTitle='TABLEAU DE BORD'; include BASE_PATH.'/app/views/layouts/header.php'; ?>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">
  <div class="bloc-press">
    <div class="bloc-header" style="text-align:center;font-weight:900">RAPPORT RECETTE - DÉPENSE PÉRIODIQUE</div>
    <div class="bloc-body">
      <form method="GET" style="display:flex;gap:8px;align-items:center;margin-bottom:12px">
        <label class="lbl">Du</label>
        <input type="date" name="debut" class="ctrl-press" style="width:150px" value="<?= htmlspecialchars($debut) ?>">
        <label class="lbl">au</label>
        <input type="date" name="fin" class="ctrl-press" style="width:150px" value="<?= htmlspecialchars($fin) ?>">
        <button type="submit" class="btn-press btn-enreg" style="padding:4px 14px">AFFICHER</button>
      </form>
      <table class="table-press" style="width:100%">
        <thead><tr><th>PÉRIODE</th><th>RECETTE</th><th>DÉPENSE</th><th>TAUX REND.</th></tr></thead>
        <tbody>
          <tr style="background:#fffde7">
            <td style="font-weight:600"><?= ($debut&&$fin)?date('d/m/Y',strtotime($debut)).' → '.date('d/m/Y',strtotime($fin)):'—' ?></td>
            <td style="text-align:right;color:#2e7d32;font-weight:700"><?= number_format($balance['entree'],0,',',' ') ?> F</td>
            <td style="text-align:right;color:#c62828;font-weight:700"><?= number_format($balance['sortie'],0,',',' ') ?> F</td>
            <td style="text-align:right;font-weight:700;color:#1565c0"><?php $taux=$balance['entree']>0?round($balance['solde']/$balance['entree']*100,1):0; ?><?= $taux ?> %</td>
          </tr>
          <tr><td colspan="4" style="background:#e8f5e9;text-align:right;font-weight:900;padding:6px 10px">Solde : <?= number_format($balance['solde'],0,',',' ') ?> FCFA</td></tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="bloc-press">
    <div class="bloc-header" style="text-align:center;font-weight:900">DETAIL DES DÉPENSES PÉRIODIQUES</div>
    <div class="bloc-body">
      <div style="display:flex;gap:8px;margin-bottom:12px;align-items:center">
        <label class="lbl">Du</label><input type="date" class="ctrl-press" style="width:150px" value="<?= date('Y-m-01') ?>">
        <label class="lbl">au</label><input type="date" class="ctrl-press" style="width:150px" value="<?= date('Y-m-d') ?>">
        <button class="btn-press btn-enreg" style="padding:4px 14px">AFFICHER</button>
      </div>
      <table class="table-press" style="width:100%">
        <thead><tr><th>DATE</th><th>LIGNE</th><th>DESCRIPTION</th><th>MONTANT</th></tr></thead>
        <tbody><tr><td colspan="4" style="text-align:center;color:#9e9e9e;padding:20px">Sélectionnez une période</td></tr></tbody>
      </table>
    </div>
  </div>
</div>
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:10px">
  <?php $cartes=[['Dépôts total','📦',$stats['total'],'#1565c0'],['Nouveaux','📥',$stats['recu'],'#546e7a'],['En traitement','⚙️',$stats['traitement'],'#f57c00'],['Prêts','✅',$stats['pret'],'#1565c0'],['Livrés','🎉',$stats['livre'],'#2e7d32'],['CA Total','💰',number_format($stats['ca'],0,',',' ').' F','#2e7d32'],['Encaissé','💵',number_format($stats['encaisse'],0,',',' ').' F','#1565c0'],['Impayés','⚠️',number_format($stats['impaye'],0,',',' ').' F','#c62828']]; foreach($cartes as [$lbl,$icon,$val,$col]): ?>
  <div style="background:#fff;border:1px solid #e0e0e0;border-radius:6px;padding:12px;box-shadow:0 1px 4px #0001;border-top:3px solid <?= $col ?>">
    <div style="font-size:20px"><?= $icon ?></div>
    <div style="font-weight:900;font-size:17px;color:<?= $col ?>;margin:4px 0 2px"><?= $val ?></div>
    <div style="font-size:11px;color:#78909c;font-weight:600;text-transform:uppercase"><?= $lbl ?></div>
  </div>
  <?php endforeach; ?>
</div>
<div class="bloc-press">
  <div class="bloc-header" style="text-align:center;font-weight:900">LISTE DES CRÉANCIERS</div>
  <div class="bloc-body" style="padding:0">
    <table class="table-press" style="width:100%">
      <thead><tr><th>CLIENT</th><th>MONTANT CRÉDIT</th><th>TAUX DE RECOUVREMENT</th><th>DURÉE</th></tr></thead>
      <tbody>
        <?php $creanciers=array_filter($recents??[],fn($d)=>($d['reste_a_payer']??0)>0); ?>
        <?php if(!empty($creanciers)): foreach($creanciers as $d): ?>
        <tr>
          <td style="font-weight:700"><?= htmlspecialchars($d['client_nom']) ?></td>
          <td style="text-align:right;color:#c62828;font-weight:700"><?= number_format($d['reste_a_payer'],0,',',' ') ?> FCFA</td>
          <td style="text-align:right"><?= $d['net_a_payer']>0?round($d['montant_paye']/$d['net_a_payer']*100,1):0 ?> %</td>
          <td style="font-size:11px;color:#546e7a"><?= date('d/m/Y',strtotime($d['created_at'])) ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="4" style="text-align:center;color:#9e9e9e;padding:20px">Aucun créancier.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include BASE_PATH.'/app/views/layouts/footer.php'; ?>
