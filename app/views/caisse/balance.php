<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">

    <!-- BARRE DE FILTRE -->
    <div class="card" style="border:1px solid #ccc; border-radius:4px; overflow:hidden; margin-bottom:20px; background:#fff;">
        <div style="background-color:#1a237e; color:#fff; padding:8px 15px; display:flex; align-items:center; gap:8px;">
            <span style="width:10px;height:10px;background:#f5c518;display:inline-block;"></span>
            <span style="font-weight:bold; font-size:13px; text-transform:uppercase;">BALANCE DE CAISSE</span>
        </div>

        <form method="GET" action="<?= APP_URL ?>/caisse/balance" style="padding:15px; display:flex; align-items:end; gap:15px; flex-wrap:wrap;">
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

    <!-- CARTES DE TOTAUX -->
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">

        <div style="background:#fff; border:1px solid #ccc; border-radius:6px; padding:25px; text-align:center; border-top:4px solid #16a34a;">
            <div style="font-size:12px; font-weight:bold; color:#64748b; text-transform:uppercase; margin-bottom:10px;">
                Total Entrées
            </div>
            <div style="font-size:32px; font-weight:900; color:#16a34a; font-family:monospace;">
                <?= number_format($balance['entrees'], 0, ',', ' ') ?> F
            </div>
        </div>

        <div style="background:#fff; border:1px solid #ccc; border-radius:6px; padding:25px; text-align:center; border-top:4px solid #dc2626;">
            <div style="font-size:12px; font-weight:bold; color:#64748b; text-transform:uppercase; margin-bottom:10px;">
                Total Sorties
            </div>
            <div style="font-size:32px; font-weight:900; color:#dc2626; font-family:monospace;">
                <?= number_format($balance['sorties'], 0, ',', ' ') ?> F
            </div>
        </div>

        <div style="background:#fff; border:1px solid #ccc; border-radius:6px; padding:25px; text-align:center; border-top:4px solid #1e3a8a;">
            <div style="font-size:12px; font-weight:bold; color:#64748b; text-transform:uppercase; margin-bottom:10px;">
                Solde
            </div>
            <div style="font-size:32px; font-weight:900; color:#1e3a8a; font-family:monospace;">
                <?= number_format($balance['solde'], 0, ',', ' ') ?> F
            </div>
        </div>

    </div>

    <div style="margin-top:20px; padding:15px; background:#f1f5f9; border-radius:6px; border-left:4px solid #1a237e;">
        <span style="font-size:12px; color:#475569;">
            📅 Période affichée : du <strong><?= date('d/m/Y', strtotime($debut)) ?></strong> au <strong><?= date('d/m/Y', strtotime($fin)) ?></strong>
        </span>
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