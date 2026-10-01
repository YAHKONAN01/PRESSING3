<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div style="display: grid; grid-template-columns: 320px 1fr; gap: 20px; padding: 10px;">

    <!-- FORMULAIRE À GAUCHE -->
    <div class="card" style="background-color: #ffffff; border: 1px solid #ccc; border-radius: 4px; overflow: hidden;">
        <div style="background-color: #1e3a8a; color: #ffffff; padding: 10px 15px; font-weight: bold; font-size: 14px; text-transform: uppercase;">
            Dépense / Mouvement
        </div>
        
        <form action="<?= APP_URL ?>/caisse/save" method="POST" style="padding: 15px;">
            
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display: block; font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #333;">
                    Rubrique du mouvement
                </label>
                <select name="sens" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; background: #fff;" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="entree">Recette / Entrée (Caisse +)</option>
                    <option value="sortie">Dépense / Sortie (Caisse -)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 10px; margin-bottom: 12px;">
                <div class="form-group">
                    <label style="display: block; font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #333;">
                        Libellé
                    </label>
                    <input type="text" name="libelle" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; background-color: #fefdeb;" required>
                </div>
                <div class="form-group">
                    <label style="display: block; font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #333;">
                        Montant
                    </label>
                    <input type="number" name="montant" value="0" min="1" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display: block; font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #333;">
                    Motif
                </label>
                <textarea name="motif" rows="4" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; resize: none;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #333;">
                    Date
                </label>
                <input type="date" name="date_op" value="<?= htmlspecialchars($date_op ?? date('Y-m-d')) ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>

            <div style="display: flex; gap: 6px; justify-content: space-between;">
                <button type="reset" style="flex: 1; padding: 8px; font-size: 12px; font-weight: bold; background-color: #fbbf24; border: none; color: #000; border-radius: 4px; cursor: pointer;">
                    ⚡ Nouveau
                </button>
                <button type="submit" style="flex: 1; padding: 8px; font-size: 12px; font-weight: bold; background-color: #2563eb; border: none; color: #fff; border-radius: 4px; cursor: pointer;">
                    💾 Enregistrer
                </button>
                <button type="button" onclick="window.print()" style="flex: 1; padding: 8px; font-size: 12px; font-weight: bold; background-color: #4b5563; border: none; color: #fff; border-radius: 4px; cursor: pointer;">
                    🖨️ Imprimer
                </button>
            </div>

        </form>
    </div>

    <!-- FILTRE + TABLEAU À DROITE -->
    <div>

        <!-- BARRE DE FILTRE -->
        <div class="card" style="border:1px solid #ccc; border-radius:4px; overflow:hidden; margin-bottom:15px; background:#fff;">
            <div style="background-color:#1a237e; color:#fff; padding:8px 15px; display:flex; align-items:center; gap:8px;">
                <span style="width:10px;height:10px;background:#f5c518;display:inline-block;"></span>
                <span style="font-weight:bold; font-size:13px; text-transform:uppercase;">OPÉRATIONS DE CAISSE</span>
            </div>

            <form method="GET" action="<?= APP_URL ?>/caisse/operations" style="padding:15px; display:flex; align-items:end; gap:15px; flex-wrap:wrap;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:bold;color:#333;margin-bottom:4px;">Période prédéfinie</label>
                    <select id="periodeSelect" style="padding:6px 10px;border:1px solid #ccc;border-radius:4px;min-width:180px;" onchange="appliquerPeriode()">
                        <option value="">Période prédéfinie</option>
                        <option value="aujourdhui">Aujourd'hui</option>
                        <option value="hier">Hier</option>
                        <option value="semaine">Cette semaine</option>
                        <option value="mois">Ce mois</option>
                        <option value="mois_dernier">Mois dernier</option>
                        <option value="annee">Cette année</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:bold;color:#333;margin-bottom:4px;">Du</label>
                    <input type="date" name="date_debut" id="dateDebut" value="<?= htmlspecialchars($debut) ?>" style="padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:bold;color:#333;margin-bottom:4px;">au</label>
                    <input type="date" name="date_fin" id="dateFin" value="<?= htmlspecialchars($fin) ?>" style="padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold" style="padding:8px 16px;">
                        🖶 Visualiser
                    </button>
                </div>
            </form>
        </div>

        <!-- TABLEAU RESULTAT -->
        <div class="card" style="border:1px solid #ccc; border-radius:4px; overflow:hidden; background:#fff;">
            <div style="background-color:#0f172a; color:#fff; padding:8px 15px; font-weight:bold; font-size:13px; text-transform:uppercase;">
                Résultats
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12.5px;">
                <thead>
                    <tr style="background-color:#000;color:#facc15;text-transform:uppercase;font-size:11px;">
                        <th style="padding:10px 15px;">Libellé</th>
                        <th style="padding:10px 15px;">Motif</th>
                        <th style="padding:10px 15px;text-align:right;">Entrée</th>
                        <th style="padding:10px 15px;text-align:right;">Sortie</th>
                        <th style="padding:10px 15px;text-align:center;">Date op</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($operations)): ?>
                    <tr><td colspan="5" style="text-align:center;padding:40px;color:#94a3b8;font-style:italic;">
                        Aucune opération enregistrée sur cette période.
                    </td></tr>
                    <?php else: ?>
                        <?php foreach ($operations as $op): ?>
                        <tr style="border-bottom:1px solid #e2e8f0;">
                            <td style="padding:10px 15px;font-weight:500;"><?= htmlspecialchars($op['libelle']) ?></td>
                            <td style="padding:10px 15px;color:#64748b;"><?= htmlspecialchars($op['motif'] ?: '-') ?></td>
                            <td style="padding:10px 15px;text-align:right;font-weight:bold;color:#16a34a;">
                                <?= $op['sens']==='entree' ? number_format($op['montant'],0,',',' ').' F' : '' ?>
                            </td>
                            <td style="padding:10px 15px;text-align:right;font-weight:bold;color:#dc2626;">
                                <?= $op['sens']==='sortie' ? number_format($op['montant'],0,',',' ').' F' : '' ?>
                            </td>
                            <td style="padding:10px 15px;text-align:center;"><?= date('d/m/Y', strtotime($op['date_op'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div style="display:flex; justify-content:flex-end; gap:20px; padding:12px 15px; background-color:#f1f5f9; border-top:2px solid #334155;">
                <span style="font-weight:bold;font-size:12px;">Total Entrées : <span style="color:#16a34a"><?= number_format($balance['entrees'],0,',',' ') ?> F</span></span>
                <span style="font-weight:bold;font-size:12px;">Total Sorties : <span style="color:#dc2626"><?= number_format($balance['sorties'],0,',',' ') ?> F</span></span>
                <span style="font-weight:bold;font-size:12px;">Solde : <span style="color:#1e3a8a"><?= number_format($balance['solde'],0,',',' ') ?> F</span></span>
            </div>
        </div>

    </div>
</div>

<script>
function appliquerPeriode() {
  const val = document.getElementById('periodeSelect').value;
  const today = new Date();
  let debut, fin;
  function fmt(d) { return d.toISOString().split('T')[0]; }

  switch(val) {
    case 'aujourdhui': debut = fin = today; break;
    case 'hier': debut = fin = new Date(today.getFullYear(), today.getMonth(), today.getDate()-1); break;
    case 'semaine':
      const jour = today.getDay() || 7;
      debut = new Date(today.getFullYear(), today.getMonth(), today.getDate()-jour+1);
      fin = today;
      break;
    case 'mois': debut = new Date(today.getFullYear(), today.getMonth(), 1); fin = today; break;
    case 'mois_dernier':
      debut = new Date(today.getFullYear(), today.getMonth()-1, 1);
      fin = new Date(today.getFullYear(), today.getMonth(), 0);
      break;
    case 'annee': debut = new Date(today.getFullYear(), 0, 1); fin = today; break;
    default: return;
  }
  document.getElementById('dateDebut').value = fmt(debut);
  document.getElementById('dateFin').value = fmt(fin);
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>