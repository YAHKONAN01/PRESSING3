<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>

<div style="
    background-image: url('<?= APP_URL ?>/assets/images/fond.png');
    background-size: contain;           /* ⬅️ Change 'cover' par 'contain' pour voir TOUTE l'image sans zoom */
    background-position: center center; /* Reste bien centrée au milieu */
    background-repeat: no-repeat;       /* Évite que l'image ne se répète si elle est plus petite */
    background-color: #f8f9fa;          /* Ajoute un fond gris clair très propre là où l'image ne passe pas */
    min-height: calc(100vh - 75px); 
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0;
">
    
    <div style="
        background: rgba(0, 0, 0, 0.6); 
        padding: 40px 60px;
        border-radius: 12px;
        text-align: center;
        backdrop-filter: blur(3px);
    ">
        <h1 style="
            font-size: 60px;
            font-weight: 900;
            color: #fff;
            letter-spacing: -2px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            margin: 0;
        ">
            ★ PRESSING ET BUANDERIE ★
        </h1>
        <p style="color:#f5c518; font-size:18px; font-weight:600; margin-top:15px; margin-bottom: 0; letter-spacing: 1px;">
            Votre linge entre de bonnes mains
        </p>
    </div>
</div>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>