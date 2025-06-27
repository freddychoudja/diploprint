<?php
// Connexion centralisée
require_once __DIR__ . '/connexion.php';
// La variable $pdo est maintenant disponible via connexion.php

// Vérification de l'envoi du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"] ?? null;
    $prenom = $_POST["prenom"] ?? null;
    $email = $_POST["email"] ?? null;
    $passwordPlain = $_POST["pass"] ?? null;
    $passwordHash  = $passwordPlain ? password_hash($passwordPlain, PASSWORD_DEFAULT) : null;

    // Vérifier que tous les champs sont remplis
    if ($nom && $prenom && $email && $passwordPlain) {
        // Vérifier l'unicité de l'email
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $emailExist = $stmt->fetchColumn();

        if ($emailExist) {
            die("Cet email est déjà utilisé.");
        }

        // Insérer les données dans la base
        $sql = "INSERT INTO users (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $passwordHash
            ]);
            echo "Inscription réussie !";
        } catch (PDOException $e) {
            error_log('Erreur inscription : ' . $e->getMessage());
            echo 'Une erreur interne est survenue.';
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
