<?php
// includes/config.php
// Configuration centralisée de la connexion PDO

// ----- Paramètres de connexion -----
const DB_HOST = 'localhost';
const DB_NAME = 'projet_diplomation';
const DB_USER = 'root';
const DB_PASS = '';

// ----- Lancement de la session (une seule fois) -----
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ----- Connexion PDO sécurisée -----
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
];

try {
    // La variable $pdo est accessible partout après le require
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        $options
    );
} catch (PDOException $e) {
    // En production, on log l'erreur sans l'afficher à l'utilisateur
    error_log('Erreur PDO : ' . $e->getMessage());
    die('Une erreur interne est survenue.');
}
