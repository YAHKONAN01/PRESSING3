<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Connexion' ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 30px; border-radius: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 320px; border-top: 4px solid #1a365d; }
        h2 { text-align: center; color: #1a365d; margin-bottom: 20px; font-size: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 11px; text-transform: uppercase; margin-bottom: 5px; color: #666; font-weight: bold; }
        input { width: 100%; padding: 8px 10px; border: 1.5px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; background: #1a365d; color: #f5c518; border: none; padding: 10px; border-radius: 4px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        button:hover { background: #2a4a7f; }
        .error { background: #fed7d7; color: #c53030; padding: 10px; border-radius: 4px; font-size: 12px; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>PRESSING & BUANDERIE</h2>
        
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="error">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= APP_URL ?>/login">
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>