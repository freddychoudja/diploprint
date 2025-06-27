<?php
session_start();
require_once __DIR__ . '/connexion.php';

// Si l'utilisateur est déjà connecté, on le redirige
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = null; // Initialiser la variable d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // --- Validation des données ---
    if (empty($nom) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'adresse e-mail n'est pas valide.";
    } else {
        // --- Vérification de l'unicité de l'email ---
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $emailExists = $stmt->fetchColumn();

            if ($emailExists) {
                $error = "Cette adresse e-mail est déjà utilisée.";
            } else {
                // --- Insertion du nouvel utilisateur ---
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe) VALUES (?, ?, ?)");
                $stmt->execute([$nom, $email, $passwordHash]);

                // Redirection vers la page de connexion avec un message de succès
                header("Location: login.php?success=1");
                exit();
            }
        } catch (PDOException $e) {
            // En cas d'autre erreur BDD, on logue et affiche un message générique
            error_log($e->getMessage());
            $error = "Une erreur est survenue. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription | PrintCF</title>
  <!-- Assurez-vous que le chemin est correct -->
  <link rel="stylesheet" href="s.css"> 
</head>
<body class="auth-page">
  <main class="form-container">
    <h1><span class="title-icon">🚀</span> Créer un Compte</h1>
    
    <!-- Affichage des erreurs éventuelles -->
    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php" novalidate>
      <div class="form-group">
        <label for="nom">Nom complet</label>
        <input type="text" id="nom" name="nom" required placeholder="Ex: Marie Curie">
      </div>
      <div class="form-group">
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" required placeholder="votre@email.com">
      </div>
      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
      </div>
      <button class="submit-btn" type="submit">S'inscrire</button>
    </form>
    
    <a class="back-link" href="login.php">Déjà inscrit ? Se connecter</a>
  </main>
</body>
</html>