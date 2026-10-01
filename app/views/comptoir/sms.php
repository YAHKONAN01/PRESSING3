<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container-fluid mt-3">
  <div class="d-flex justify-content-between align-items-center mb-3 text-white p-2 rounded" style="background-color: #1a237e !important;">
    <h6 class="fw-bold m-0">📱 COMPTOIR — ENVOI SMS NOTIFICATION</h6>
    <button class="btn btn-warning btn-sm fw-bold px-3" onclick="window.location.reload()">↺ Actualiser</button>
  </div>

  <table class="table table-bordered table-hover table-sm align-middle mb-3">
    <thead class="table-dark" style="background-color: #000000;">
      <tr class="text-warning small text-uppercase">
        <th>CODE DÉPÔT</th>
        <th>CLIENT</th>
        <th>TÉLÉPHONE</th>
        <th>DATE DÉPÔT</th>
        <th class="text-center" style="width: 150px;">ACTION</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($clientsPrets)): ?>
        <?php foreach($clientsPrets as $c): ?>
        <tr>
          <td class="fw-bold text-primary"><?= htmlspecialchars($c['code_depot']) ?></td>
          <td class="fw-bold text-secondary"><?= htmlspecialchars($c['client_nom']) ?></td>
          <td class="fw-bold text-dark"><?= htmlspecialchars($c['client_telephone']) ?></td>
          <td style="font-size:12px;"><?= date('d/m/Y', strtotime($c['date_depot'])) ?></td>
          <td class="text-center">
            <button type="button" class="btn btn-success btn-xs fw-bold px-2 py-1" style="font-size: 11px;" 
                    onclick="envoyerSMS('<?= $c['code_depot'] ?>', '<?= addslashes($c['client_nom']) ?>', '<?= $c['client_telephone'] ?>')">
              📱 Envoyer SMS
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center text-muted py-4 small">
            Aucun client en attente de notification par SMS (tous les vêtements prêts ont été notifiés ou aucun vêtement n'est emballé).
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
/**
 * Fonction JavaScript pour gérer l'envoi du SMS
 */
function envoyerSMS(code, nom, telephone) {
  if (!telephone || telephone.trim() === '') {
    alert("Le client n'a pas de numéro de téléphone renseigné.");
    return;
  }

  // Exemple de message personnalisé pour Prestige Laverie 1
  const message = `Bonjour M/Mme ${nom}, votre commande ${code} est prête chez PRESTIGE LAVERIE. Vous pouvez passer la récupérer. Merci pour votre confiance !`;

  if (confirm(`Voulez-vous envoyer le SMS de notification à ${nom} (${telephone}) ?`)) {
    
    // OPTION A : Si vous utilisez une API SMS en arrière-plan via AJAX (Recommandé)
    /*
    fetch('<?= APP_URL ?>/comptoir/sms/send', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ 'telephone': telephone, 'message': message, 'code_depot': code })
    })
    .then(response => response.json())
    .then(data => {
       if(data.success) {
         alert('SMS envoyé avec succès !');
         window.location.reload();
       } else {
         alert("Erreur lors de l'envoi du SMS.");
       }
    });
    */

    // OPTION B : Solution simple de secours (Ouvre l'application SMS du téléphone/PC si compatible)
    const urlSms = `sms:${telephone}?body=${encodeURIComponent(message)}`;
    window.location.href = urlSms;
  }
}
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>