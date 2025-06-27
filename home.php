<?php
session_start();
require_once __DIR__ . '/connexion.php';

// Si un utilisateur est déjà connecté, aller au dashboard
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Logique de "première installation" : si aucun utilisateur n'existe, on force l'inscription.
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        header("Location: register.php");
        exit();
    }
} catch (PDOException $e) {
    error_log('Erreur vérification utilisateurs sur home.php : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bienvenue sur PrintCF</title>
  <link rel="stylesheet" href="s.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body class="landing-page-body">

  <div class="landing-page-wrapper">
      
      <!-- Section "Héros" pour un impact maximal -->
      <header class="hero-section">
          <h1>
              <span class="brand-name">PrintCF</span>
              <span class="subtitle">La Plateforme Intelligente pour vos Dossiers de Diplomation</span>
          </h1>
          <p class="hero-description">
              Simplifiez, accélérez et sécurisez la gestion des dossiers académiques.
          </p>
      </header>

      <!-- Panneau principal avec les fonctionnalités et les appels à l'action -->
      <main class="features-panel">
          <h2>Toutes vos fonctionnalités centralisées</h2>
          <ul class="features-list">
              <li><span>✅</span> Suivi des dossiers complets en un clin d'œil.</li>
              <li><span>⚠️</span> Identification instantanée des pièces manquantes.</li>
              <li><span>✏️</span> Mise à jour facile des informations étudiantes.</li>
              <li><span>💾</span> Exportation de listes professionnelles en PDF.</li>
          </ul>

          <div class="cta-buttons">
              <a class="submit-btn" href="login.php">Accéder à mon espace</a>
              <a class="back-link" href="register.php">Créer un nouveau compte</a>
          </div>
      </main>

      <footer class="landing-footer">
          © <?= date('Y') ?> - PrintCF. Tous droits réservés.
      </footer>
  </div>

</body>
</html>