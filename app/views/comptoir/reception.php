<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<style>
.section-client { background:#e8f5e9; border:1.5px solid #66bb6a; border-radius:4px; padding:10px 14px; }
.lbl { font-weight:700; font-size:12px; color:#37474f; }
.ctrl { border:1.5px solid #9e9e9e; border-radius:3px; padding:4px 8px; font-size:13px; width:100%; height:28px; outline:none; box-sizing:border-box; }
.tarif-box { background:#fff; border:1.5px solid #9e9e9e; border-radius:3px; padding:4px 10px; font-weight:700; font-size:14px; color:#1565c0; text-align:center; height:28px; display:flex; align-items:center; justify-content:center; min-width:110px; }
.table-press thead th { background:#111; color:#f5c518; padding:6px 10px; font-size:11px; text-transform:uppercase; }
.table-press tbody tr:nth-child(odd) { background:#f5f7ff; }
.table-press tbody tr:nth-child(even) { background:#eef1fb; }
.table-press tbody td { padding:5px 10px; border-bottom:1px solid #e0e0e0; font-size:13px; }
.btn-ajouter { background:#000; color:#f5c518; border:2px solid #555; border-radius:4px; padding:0 16px; font-weight:900; font-size:12px; cursor:pointer; height:65px; width:90px; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:2px; }
.zone-totaux { display:grid; grid-template-columns:repeat(6,1fr); gap:8px; background:#e3f2fd; border:1px solid #90caf9; border-radius:4px; padding:8px 12px; }
.total-label { font-size:9px; font-weight:700; text-transform:uppercase; background:#e0e0e0; border:1px solid #bdbdbd; padding:2px 4px; border-radius:2px; margin-bottom:3px; text-align:center; }
.total-val { background:#fff; border:2px inset #9e9e9e; border-radius:3px; padding:5px; font-weight:900; font-size:14px; text-align:center; width:100%; box-sizing:border-box; }
</style>

<div style="background:#c8c8c8;border:2px solid #888;border-radius:4px;overflow:hidden;margin:8px">

  <!-- EN-TÊTE -->
  <div style="background:linear-gradient(90deg,#0d47a1,#1e88e5);color:#fff;padding:5px 14px;display:flex;justify-content:space-between;align-items:center">
    <span style="font-weight:900;font-size:11px;letter-spacing:2px;background:#0a2d6b;border:1px solid #f5c518;color:#4fc3f7;padding:2px 10px;border-radius:3px">PRESSING</span>
    <span style="font-weight:700;font-size:14px;letter-spacing:2px">COMPTOIR DE RÉCEPTION</span>
    <span style="color:#f5c518;font-weight:900;font-size:15px">TÉL. : <?= htmlspecialchars($telephone) ?></span>
  </div>

  <div style="padding:10px;display:flex;flex-direction:column;gap:8px">

    <!-- LIGNE 1 : CLIENT + VÊTEMENT -->
    <div style="display:grid;grid-template-columns:310px 1fr;gap:10px">

      <!-- BLOC CLIENT -->
      <div class="section-client">
        <div style="font-weight:900;font-size:11px;color:#1b5e20;border-bottom:1px solid #a5d6a7;margin-bottom:6px;padding-bottom:3px;letter-spacing:1px">CLIENT</div>

        <div style="display:grid;grid-template-columns:100px 1fr;align-items:center;gap:4px;margin-bottom:5px">
          <label class="lbl">Nom client</label>
          <input type="text" id="clientNom" class="ctrl" placeholder="Nom du client">
        </div>
        <div style="display:grid;grid-template-columns:100px 1fr;align-items:center;gap:4px;margin-bottom:5px">
          <label class="lbl">Téléphone</label>
          <input type="tel" id="clientTel" class="ctrl" placeholder="+225 07 XX XX XX">
        </div>
        <div style="display:grid;grid-template-columns:100px 1fr;align-items:center;gap:4px;margin-bottom:5px">
          <label class="lbl">Mode retrait</label>
          <select id="modeRetrait" class="ctrl">
            <option>Retrait au dépôt</option>
            <option>Livraison à domicile</option>
            <option>Livraison bureau</option>
          </select>
        </div>
        <div style="display:grid;grid-template-columns:100px 1fr;align-items:center;gap:4px">
          <label class="lbl">Résidence</label>
          <input type="text" id="clientResidence" class="ctrl" placeholder="Quartier / adresse">
        </div>
      </div>

      <!-- BLOC VÊTEMENT -->
      <div style="background:#f8f9fa;border:1.5px solid #9e9e9e;border-radius:4px;padding:8px 12px">
        <div style="display:grid;grid-template-columns:1fr auto auto;gap:8px;align-items:end;margin-bottom:8px">
          <div>
            <div class="lbl" style="font-size:9px;text-transform:uppercase;letter-spacing:1px;margin-bottom:3px">TYPE DE VÊTEMENT</div>
            <div style="display:flex;gap:4px">
                <select id="typeVetement" class="ctrl-press" style="flex:1; height:28px; border:1.5px solid #9e9e9e; border-radius:3px; padding:0 6px;" onchange="onVetementChange()">
                    <option value="">-- Sélectionner --</option>
                    <?php if (!empty($vetements)): ?>
                        <?php foreach($vetements as $v): ?>
                        <option value="<?= htmlspecialchars($v['id']) ?>" data-tarif="<?= htmlspecialchars($v['tarif'] ?? 0) ?>" data-nom="<?= htmlspecialchars($v['libelle']) ?>">
                            <?= htmlspecialchars($v['libelle']) ?>
                        </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button type="button" onclick="ouvrirListeDepots()" style="background:#333;color:#f5c518;border:none;border-radius:3px;padding:0 8px;height:28px;cursor:pointer">≡</button>
            </div>
          </div>
          <div>
            <div class="lbl" style="font-size:9px;text-transform:uppercase;margin-bottom:3px">TARIF</div>
            <input type="number" id="tarifInput" class="ctrl" style="width:100px;text-align:right" value="0" oninput="updateTotal()">
          </div>
          <div>
            <div class="lbl" style="font-size:9px;text-transform:uppercase;margin-bottom:3px">QTÉ</div>
            <input type="number" id="qteInput" class="ctrl" style="width:60px;text-align:center" value="1" min="1" oninput="updateTotal()">
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 160px 1fr;gap:8px;align-items:end;margin-bottom:6px">
          <div>
            <div class="lbl" style="font-size:9px;text-transform:uppercase;margin-bottom:3px">DESCRIPTION</div>
            <input type="text" id="description" class="ctrl" placeholder="Style, Couleur, Motif...">
          </div>
          <div>
            <div class="lbl" style="font-size:9px;text-transform:uppercase;margin-bottom:3px">SERVICE</div>
            <select id="serviceType" class="ctrl">
              <option>Pressing</option><option>Lavage</option>
              <option>Nettoyage à sec</option><option>Repassage</option>
            </select>
          </div>
          <div>
            <div class="lbl" style="font-size:9px;text-transform:uppercase;margin-bottom:3px">TOTAL LIGNE</div>
            <div class="tarif-box" id="totalLigne">0 FCFA</div>
          </div>
        </div>
        <div>
          <div class="lbl" style="font-size:9px;text-transform:uppercase;margin-bottom:3px">OBSERVATION</div>
          <input type="text" id="observation" class="ctrl" placeholder="Défaut constaté sur le vêtement">
        </div>
      </div>
    </div>

    <!-- BOUTON AJOUTER -->
    <div style="display:flex;justify-content:flex-end">
      <button class="btn-ajouter" onclick="ajouterLigne()">
        <span style="font-size:18px">+</span><span>AJOUTER</span><span>AU PANIER</span>
      </button>
    </div>

    <!-- TABLEAU PANIER -->
    <div style="background:#fff;border:1.5px solid #888;border-radius:3px;min-height:120px;overflow:hidden">
      <table class="table-press" style="width:100%;border-collapse:collapse">
        <thead>
          <tr>
            <th>DÉSIGNATION</th><th>DESCRIPTION</th><th style="width:100px">TARIF</th>
            <th style="width:70px">QTÉ</th><th style="width:110px">MONTANT</th><th style="width:40px"></th>
          </tr>
        </thead>
        <tbody id="lignesTable">
          <tr id="ligneVide">
            <td colspan="6" style="text-align:center;color:#9e9e9e;padding:30px;font-style:italic">
              Aucun article — sélectionnez un vêtement et cliquez AJOUTER AU PANIER
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- TOTAUX -->
    <div class="zone-totaux">
      <div>
        <div class="total-label">MONTANT TOTAL</div>
        <div class="total-val" id="totalMontant">0 FCFA</div>
      </div>
      <div>
        <div class="total-label">RÉDUCTION</div>
        <input type="number" id="reduction" class="total-val" value="0" min="0" oninput="recalculer()" style="border:2px inset #9e9e9e;cursor:text">
      </div>
      <div>
        <div class="total-label">NET À PAYER</div>
        <div class="total-val" id="netAPayer" style="background:#fffde7;border-color:#f9a825">0</div>
      </div>
      <div>
        <div class="total-label">MONTANT PAYÉ</div>
        <input type="number" id="montantPaye" class="total-val" value="0" min="0" style="background:#e8f5e9;border:2px inset #9e9e9e;cursor:text">
      </div>
      <div>
        <div class="total-label">DATE RETRAIT</div>
        <input type="date" id="dateRetrait" class="total-val" style="font-size:12px;border:2px inset #9e9e9e">
      </div>
      <div>
        <div class="total-label">HEURE RETRAIT</div>
        <input type="time" id="heureRetrait" class="total-val" style="font-size:12px;border:2px inset #9e9e9e">
      </div>
    </div>

    <!-- ZONE BAS -->
    <div style="display:flex;gap:8px;align-items:center;background:#ddd;border:1px solid #bbb;border-radius:4px;padding:6px 10px;flex-wrap:wrap">
      <div>
        <div style="font-size:9px;font-weight:700;text-transform:uppercase;background:#e0e0e0;border:1px solid #bdbdbd;padding:2px 6px;border-radius:2px;margin-bottom:2px">DATE DE DÉPÔT</div>
        <div style="background:#fff;border:2px inset #9e9e9e;border-radius:3px;padding:3px 8px;font-weight:700;font-size:13px" id="dateDepot"><?= date('d/m/Y') ?></div>
      </div>
      <div>
        <div style="font-size:9px;font-weight:700;text-transform:uppercase;background:#e0e0e0;border:1px solid #bdbdbd;padding:2px 6px;border-radius:2px;margin-bottom:2px">CODE DE DÉPÔT</div>
        <div style="background:#fff;border:2px inset #9e9e9e;border-radius:3px;padding:3px 8px;font-weight:700;font-size:15px;color:#c62828;letter-spacing:2px" id="codeDepot">—</div>
      </div>
      <div style="display:flex;gap:8px;margin-left:auto;flex-wrap:wrap">
        <button class="btn btn-warning fw-bold btn-sm" onclick="nouveauDepot()">✦ Nouveau +</button>
        <button class="btn btn-primary fw-bold btn-sm" onclick="enregistrerDepot()">✔ Enregistrer</button>
        <button class="btn btn-secondary fw-bold btn-sm" onclick="window.location='<?= APP_URL ?>/comptoir/reception'">📋 Liste des dépôts</button>
        <button class="btn btn-dark fw-bold btn-sm" onclick="window.print()">🖨️ Imprimer</button>
      </div>
    </div>

  </div>
</div>

<!-- FORMULAIRE CACHÉ pour l'envoi -->
<form id="formDepot" method="POST" action="<?= APP_URL ?>/comptoir/reception/save" style="display:none">
  <input type="hidden" name="client_nom" id="fClientNom">
  <input type="hidden" name="client_telephone" id="fClientTel">
  <input type="hidden" name="client_residence" id="fClientRes">
  <input type="hidden" name="mode_retrait" id="fModeRetrait">
  <input type="hidden" name="reduction" id="fReduction">
  <input type="hidden" name="montant_paye" id="fMontantPaye">
  <input type="hidden" name="date_retrait" id="fDateRetrait">
  <input type="hidden" name="heure_retrait" id="fHeureRetrait">
  <input type="hidden" name="panier" id="fPanier">
</form>

<script>
let panier = [];

// Init date retrait par défaut (aujourd'hui + 2 jours)
document.addEventListener('DOMContentLoaded', () => {
  const dr = new Date();
  dr.setDate(dr.getDate() + 2);
  document.getElementById('dateRetrait').value = dr.toISOString().split('T')[0];
});

// Met à jour le tarif automatiquement lorsqu'on sélectionne un vêtement dans la liste déroulante
function onVetementChange() {
  const select = document.getElementById('typeVetement');
  const selectedOption = select.options[select.selectedIndex];
  const tarif = selectedOption.getAttribute('data-tarif') || 0;
  document.getElementById('tarifInput').value = tarif;
  updateTotal();
}

// Ouvre la liste des dépôts ou gère le bouton ≡
function ouvrirListeDepots() {
  window.location.href = '<?= APP_URL ?>/fichiers/vetements';
}

// Calcul du total d'une ligne
function updateTotal() {
  const tarif = parseFloat(document.getElementById('tarifInput').value) || 0;
  const qte   = parseInt(document.getElementById('qteInput').value) || 1;
  document.getElementById('totalLigne').textContent = (tarif * qte).toLocaleString('fr-FR') + ' FCFA';
}

// Ajouter une ligne au panier
function ajouterLigne() {
  const select = document.getElementById('typeVetement');
  const selectedOption = select.options[select.selectedIndex];
  const designation = selectedOption ? selectedOption.getAttribute('data-nom') || '' : '';

  if (!select.value || !designation) { 
    alert('Veuillez sélectionner un type de vêtement.'); 
    return; 
  }

  const tarif   = parseFloat(document.getElementById('tarifInput').value) || 0;
  const qte     = parseInt(document.getElementById('qteInput').value) || 1;
  const montant = tarif * qte;

  panier.push({
    id:          Date.now(),
    designation: designation,
    description: document.getElementById('description').value,
    service:     document.getElementById('serviceType').value,
    observation: document.getElementById('observation').value,
    tarif:       tarif,
    quantite:    qte,
    montant:     montant,
  });

  renderPanier();
  recalculer();

  // Reset champs vêtement
  select.value = '';
  document.getElementById('description').value  = '';
  document.getElementById('observation').value  = '';
  document.getElementById('tarifInput').value   = 0;
  document.getElementById('qteInput').value     = 1;
  document.getElementById('totalLigne').textContent = '0 FCFA';
}

// Afficher le panier dans le tableau
function renderPanier() {
  const tbody = document.getElementById('lignesTable');
  if (!panier.length) {
    tbody.innerHTML = '<tr id="ligneVide"><td colspan="6" style="text-align:center;color:#9e9e9e;padding:30px;font-style:italic">Aucun article</td></tr>';
    return;
  }
  tbody.innerHTML = panier.map(l => `
    <tr>
      <td><strong>${esc(l.designation)}</strong></td>
      <td style="font-size:11px;color:#546e7a">${esc(l.description) || '—'}</td>
      <td style="text-align:right">${l.tarif.toLocaleString('fr-FR')} F</td>
      <td style="text-align:center">${l.quantite}</td>
      <td style="text-align:right;font-weight:700;color:#1565c0">${l.montant.toLocaleString('fr-FR')} F</td>
      <td><button onclick="supprimerLigne(${l.id})" style="background:#c62828;color:#fff;border:none;border-radius:3px;padding:2px 6px;cursor:pointer;font-size:11px">✕</button></td>
    </tr>
  `).join('');
}

// Supprimer une ligne du panier
function supprimerLigne(id) {
  panier = panier.filter(l => l.id !== id);
  renderPanier();
  recalculer();
}

// Recalculer les totaux
function recalculer() {
  const total    = panier.reduce((s, l) => s + l.montant, 0);
  const reduction = parseInt(document.getElementById('reduction').value) || 0;
  const net      = Math.max(0, total - reduction);
  document.getElementById('totalMontant').textContent = total.toLocaleString('fr-FR') + ' FCFA';
  document.getElementById('netAPayer').textContent    = net.toLocaleString('fr-FR');
}

// Nouveau dépôt (reset tout)
function nouveauDepot() {
  if (panier.length && !confirm('Effacer et commencer un nouveau dépôt ?')) return;
  panier = [];
  renderPanier();
  document.getElementById('clientNom').value      = '';
  document.getElementById('clientTel').value      = '';
  document.getElementById('clientResidence').value= '';
  document.getElementById('reduction').value      = 0;
  document.getElementById('montantPaye').value    = 0;
  recalculer();
}

// Enregistrer le dépôt
function enregistrerDepot() {
  const nom = document.getElementById('clientNom').value.trim();
  const tel = document.getElementById('clientTel').value.trim();
  if (!nom) { alert('⚠️ Saisissez le nom du client.'); return; }
  if (!panier.length) { alert('⚠️ Ajoutez au moins un article.'); return; }

  document.getElementById('fClientNom').value    = nom;
  document.getElementById('fClientTel').value    = tel;
  document.getElementById('fClientRes').value    = document.getElementById('clientResidence').value;
  document.getElementById('fModeRetrait').value  = document.getElementById('modeRetrait').value;
  document.getElementById('fReduction').value    = document.getElementById('reduction').value;
  document.getElementById('fMontantPaye').value  = document.getElementById('montantPaye').value;
  document.getElementById('fDateRetrait').value  = document.getElementById('dateRetrait').value;
  document.getElementById('fHeureRetrait').value = document.getElementById('heureRetrait').value;
  document.getElementById('fPanier').value       = JSON.stringify(panier);

  document.getElementById('formDepot').submit();
}

function esc(s) {
  if (!s) return '';
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>