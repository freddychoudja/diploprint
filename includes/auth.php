<?php
// includes/auth.php
// Démarre la session si nécessaire puis vérifie que l'utilisateur est connecté ;
// sinon on redirige vers la page d'accueil.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: /bd/home.php');
    exit();
}
