<?php
session_start();
require 'connexion.php';

try {
    $stmt = $pdo->query("SELECT id, matricule, nom, prenom FROM etudiants ORDER BY nom, prenom");
    $etudiantsListe = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur lors de la récupération des étudiants : ' . $e->getMessage());
}

$etudiants = [];
$etudiantSelectionne = null;
$dossierComplet = false;

if (isset($_GET['etudiant_id']) && ctype_digit($_GET['etudiant_id'])) {
    $id = (int)$_GET['etudiant_id'];

    $stmt = $pdo->prepare("SELECT e.id, e.matricule, e.nom, e.prenom, f.nom_filiere FROM etudiants e JOIN filieres f ON e.filiere_id = f.id WHERE e.id = ?");
    $stmt->execute([$id]);
    $etudiantSelectionne = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($etudiantSelectionne) {
        $q = "SELECT COUNT(1)
              FROM pieces p
              LEFT JOIN etudiant_piece ep ON ep.id_piece = p.id AND ep.id_etudiant = ?
              WHERE ep.id IS NULL OR ep.statut = 0";
        $c = $pdo->prepare($q);
        $c->execute([$id]);
        $dossierComplet = ($c->fetchColumn() == 0);

        // --- Nouveaux calculs pour connaître l'état détaillé du dossier ---
        // Nombre total de pièces requises
        $stmtTotal = $pdo->query("SELECT COUNT(*) FROM pieces");
        $totalPieces = (int) $stmtTotal->fetchColumn();

        // Récupération de la liste des pièces manquantes
        $stmtMissing = $pdo->prepare("SELECT p.nom_piece
                                       FROM pieces p
                                       LEFT JOIN etudiant_piece ep ON ep.id_piece = p.id AND ep.id_etudiant = ?
                                       WHERE ep.id IS NULL OR ep.statut = 0");
        $stmtMissing->execute([$id]);
        $listePiecesManquantes = $stmtMissing->fetchAll(PDO::FETCH_COLUMN);
        $nombreManquantes = count($listePiecesManquantes);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Étudiant | PrintCF</title>
    <link rel="stylesheet" href="s.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="content-wrapper">
  <div class="page-container">
    <h1>🎓 Espace Étudiant</h1>
    <a href="index.php" class="back-link">⬅ Retour au Dashboard</a>

    <form method="get" class="student-form">
      <label for="etudiant_id">Sélectionnez votre matricule :</label>
      <div class="select-wrapper">
        <select name="etudiant_id" id="etudiant_id" required>
          <option value="">-- Choisissez un étudiant --</option>
          <?php foreach ($etudiantsListe as $et): ?>
            <option value="<?= $et['id'] ?>" <?= ($etudiantSelectionne && $etudiantSelectionne['id'] == $et['id'] ? 'selected' : '') ?>>
              <?= htmlspecialchars($et['matricule'] . ' - ' . $et['nom'] . ' ' . $et['prenom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="submit-btn">Vérifier</button>
      </div>
    </form>

    <?php if ($etudiantSelectionne): ?>
      <div class="student-status">
        <h2>Informations Étudiant</h2>
        <p><strong>Matricule :</strong> <?= htmlspecialchars($etudiantSelectionne['matricule']) ?></p>
        <p><strong>Nom :</strong> <?= htmlspecialchars($etudiantSelectionne['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($etudiantSelectionne['prenom']) ?></p>
        <p><strong>Filière :</strong> <?= htmlspecialchars($etudiantSelectionne['nom_filiere']) ?></p>

        <?php if ($dossierComplet): ?>
          <p class="success">✅ Votre dossier est complet.</p>
          <a class="download-btn" href="generate_diplome.php?id=<?= $etudiantSelectionne['id'] ?>" target="_blank">Télécharger mon Diplôme</a>
        <?php else: ?>
          <p class="warning">⚠ Votre dossier n'est pas encore complet : <?= $nombreManquantes ?>/<?= $totalPieces ?> pièces manquantes.</p>
          <?php if ($nombreManquantes): ?>
            <ul class="missing-list">
              <?php foreach ($listePiecesManquantes as $pieceNom): ?>
                <li><?= htmlspecialchars($pieceNom) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <a class="submit-btn" href="update_etudiant.php?id=<?= $etudiantSelectionne['id'] ?>">👉 Mettre à jour mon dossier</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    
  </div>
</main>
</body>
</html>
