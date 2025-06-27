<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Use $pageTitle set by each page, else default
$title = isset($pageTitle) ? $pageTitle . ' | PrintCF' : 'PrintCF';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/bd/s.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-vMkwvW2QlgBsXfxdTOKx+uPu9rbAiSlzZlZTa3YL6hFLaeLjNIeoh4gSkrwNJRiYBLqF0ULM6dLNw+PH6Y4K7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header class="main-header">
    <h1 class="logo">PrintCF</h1>

    <?php if (isset($_SESSION['user'])): ?>
        <nav class="main-nav">
            <a href="/bd/index.php">Dashboard</a>
            <a href="/bd/liste_complets.php">Dossiers complets</a>
            <a href="/bd/liste_incomplets.php">Dossiers incomplets</a>
            <a href="/bd/rechercher_etudiant.php">Recherche</a>
            <a href="/bd/ajouter_etudiant.php">Ajouter étudiant</a>
            <a href="/bd/update_etudiant.php">Mise à jour</a>
            <a href="/bd/espace_etudiant.php">Espace étudiant</a>
            <a href="/bd/logout.php">Déconnexion</a>
        </nav>
    <?php else: ?>
        <nav class="main-nav">
            <a href="/bd/home.php">Accueil</a>
            <a href="/bd/login.php">Connexion</a>
            <a href="/bd/register.php">Inscription</a>
            <a href="/bd/espace_etudiant.php">Espace étudiant</a>
        </nav>
    <?php endif; ?>
</header>

<main class="container">
