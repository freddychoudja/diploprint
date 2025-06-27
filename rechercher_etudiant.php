<?php
session_start();
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/includes/header.php';

$query = trim($_GET['q'] ?? '');
$results = [];
if ($query !== '') {
    $term = "%{$query}%";
    $stmt = $pdo->prepare("SELECT id, matricule, nom, prenom FROM etudiants WHERE matricule LIKE ? OR nom LIKE ? OR prenom LIKE ? ORDER BY nom, prenom");
    $stmt->execute([$term, $term, $term]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>🔍 Recherche Étudiant | PrintCF</title>
    <link rel="stylesheet" href="s.css">
</head>
<body>
<main class="content-wrapper">
  <div class="form-container">
    <h1>🔍 Rechercher un Étudiant</h1>
    <a href="index.php" class="back-link">⬅ Retour au Dashboard</a>

    <form method="get" class="add-form" style="grid-template-columns:1fr;">
        <div class="form-group">
            <label for="q">Matricule ou Nom</label>
            <input type="text" id="q" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Entrez un matricule ou un nom" required>
        </div>
        <button type="submit" class="submit-btn" style="grid-column:1/-1;">Rechercher</button>
    </form>

    <?php if ($query !== ''): ?>
        <h2 style="margin-top:2rem;">Résultats</h2>
        <?php if (empty($results)): ?>
            <p>Aucun étudiant trouvé.</p>
        <?php else: ?>
            <table style="width:100%;margin-top:1rem;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:8px;border-bottom:1px solid #444;">Matricule</th>
                        <th style="padding:8px;border-bottom:1px solid #444;">Nom</th>
                        <th style="padding:8px;border-bottom:1px solid #444;">Prénom</th>
                        <th style="padding:8px;border-bottom:1px solid #444;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $et): ?>
                        <tr>
                            <td style="padding:8px;"><?= htmlspecialchars($et['matricule']) ?></td>
                            <td style="padding:8px;"><?= htmlspecialchars($et['nom']) ?></td>
                            <td style="padding:8px;"><?= htmlspecialchars($et['prenom']) ?></td>
                            <td style="padding:8px;"><a href="espace_etudiant.php?etudiant_id=<?= $et['id'] ?>" class="submit-btn" style="padding:6px 12px;">Voir</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
