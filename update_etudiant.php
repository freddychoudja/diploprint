<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . '/includes/header.php';
require 'connexion.php';

// --- LOGIQUE DE RÉCUPÉRATION DES DONNÉES (INCHANGÉE) ---
$id_etudiant = $_GET['id'] ?? null;
$etudiants = $pdo->query("SELECT id, nom, prenom FROM etudiants ORDER BY nom, prenom")->fetchAll(PDO::FETCH_ASSOC);

$etudiant = null;
$pieces = [];
if ($id_etudiant) {
    // ... (votre logique de récupération de $etudiant et $pieces reste ici)
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
    $stmt->execute([$id_etudiant]);
    $etudiant = $stmt->fetch();

    $stmt = $pdo->prepare("
        SELECT p.id, p.nom_piece, ep.statut
        FROM pieces p
        LEFT JOIN etudiant_piece ep ON p.id = ep.id_piece AND ep.id_etudiant = ?
    ");
    $stmt->execute([$id_etudiant]);
    $pieces = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// --- LOGIQUE DE TRAITEMENT DU FORMULAIRE (INCHANGÉE) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // ... (votre logique de mise à jour reste ici)
    $stmt = $pdo->prepare("UPDATE etudiants SET nom=?, prenom=?, date_naissance=?, sexe=?, lieu_naissance=? WHERE id=?");
    $stmt->execute([
        $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'],
        $_POST['sexe'], $_POST['lieu_naissance'], $_POST['id_etudiant']
    ]);

    $all_pieces_stmt = $pdo->query("SELECT id FROM pieces");
    $all_pieces = $all_pieces_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($all_pieces as $pieceIter) {
        $id_piece = $pieceIter['id'];
        $statut = isset($_POST['pieces'][$id_piece]) ? 1 : 0;
        $stmt = $pdo->prepare("
            INSERT INTO etudiant_piece (id_etudiant, id_piece, statut)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE statut = ?
        ");
        $stmt->execute([$_POST['id_etudiant'], $id_piece, $statut, $statut]);
    }
    header("Location: update_etudiant.php?id=".$_POST['id_etudiant']."&success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>📝 Mise à jour | PrintCF</title>
    <link rel="stylesheet" href="s.css"> <!-- Ou s.css -->
</head>
<body>

    <main class="content-wrapper">
        <div class="page-container">
            <h1>📝 Mettre à jour un Dossier</h1>
            
            <!-- FORMULAIRE DE SÉLECTION D'ÉTUDIANT -->
            <form method="get" class="student-selector-form">
                <label for="id">Choisir un étudiant à modifier :</label>
                <div class="select-wrapper">
                    <select name="id" id="id" onchange="this.form.submit()">
                        <option value="">-- Sélectionner un profil --</option>
                        <?php foreach ($etudiants as $et): ?>
                            <option value="<?= $et['id'] ?>" <?= ($id_etudiant == $et['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($et['nom'].' '.$et['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <!-- Message de succès stylisé -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert-success">✔ Informations enregistrées avec succès.</div>
            <?php endif; ?>

            <!-- Si un étudiant est sélectionné, afficher le formulaire de mise à jour -->
            <?php if ($etudiant): ?>
                <form method="post" class="update-form">
                    <input type="hidden" name="id_etudiant" value="<?= $etudiant['id'] ?>">

                    <div class="update-grid">
                        <!-- Colonne 1 : Informations personnelles -->
                        <div class="info-panel">
                            <h2 class="panel-title">Informations Personnelles</h2>
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_naissance">Date de naissance</label>
                                <input type="date" id="date_naissance" name="date_naissance" value="<?= $etudiant['date_naissance'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="sexe">Sexe</label>
                                <select id="sexe" name="sexe">
                                    <option value="M" <?= $etudiant['sexe'] == 'M' ? 'selected' : '' ?>>Masculin</option>
                                    <option value="F" <?= $etudiant['sexe'] == 'F' ? 'selected' : '' ?>>Féminin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lieu_naissance">Lieu de naissance</label>
                                <input type="text" id="lieu_naissance" name="lieu_naissance" value="<?= htmlspecialchars($etudiant['lieu_naissance']) ?>">
                            </div>
                        </div>

                        <!-- Colonne 2 : Pièces du dossier -->
                        <div class="checklist-panel">
                            <h2 class="panel-title">Pièces du Dossier</h2>
                            <div class="checkbox-list">
                                <?php foreach ($pieces as $piece): ?>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="pieces[<?= $piece['id'] ?>]" value="1" <?= $piece['statut'] ? 'checked' : '' ?>>
                                        <span class="custom-checkbox"></span>
                                        <span class="checkbox-label"><?= htmlspecialchars($piece['nom_piece']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="update" class="submit-btn">💾 Mettre à jour</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>