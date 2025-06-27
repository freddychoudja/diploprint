<?php
session_start();
require_once __DIR__ . '/connexion.php';

// Si l'utilisateur est déjà connecté, on le redirige vers le dashboard
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = null; // Initialiser la variable d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit();
    } else {
        // Message d'erreur plus clair et stylisé
        $error = "L'adresse e-mail ou le mot de passe est incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion | PrintCF</title>
  <!-- Assurez-vous que le chemin est correct pour votre projet -->
  <link rel="stylesheet" href="s.css"> 
</head>
<body class="auth-page">
  <!-- Centrage vertical et horizontal grâce au CSS sur le body -->
  <main class="form-container">
    <h1><span class="title-icon">🔒</span> Connexion</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert-success">✅ Inscription réussie ! Vous pouvez maintenant vous connecter.</div>
<?php endif; ?>


    
    <!-- Message d'erreur stylisé via CSS -->
    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" novalidate>
      <div class="form-group">
        <label for="email">Adresse e-mail</label>
        <!-- type="email" pour une meilleure sémantique et expérience mobile -->
        <input type="email" id="email" name="email" required placeholder="votre@email.com">
      </div>
      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
      </div>
      <button class="submit-btn" type="submit">Se connecter</button>
    </form>
    
    <a class="back-link" href="register.php">Pas encore de compte ? S'inscrire</a>
  </main>
</body>
</html>