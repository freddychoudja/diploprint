<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/connexion.php';

// --- Récupération des filières pour le <select> ---
try {
    $stmtFil = $pdo->query("SELECT id, nom_filiere FROM filieres ORDER BY nom_filiere ASC");
    $filieres = $stmtFil->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des filières : " . $e->getMessage());
}

$success = false;
$error    = '';

// --- Traitement du formulaire d'ajout ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule      = trim($_POST['matricule'] ?? '');
    $nom            = trim($_POST['nom'] ?? '');
    $prenom         = trim($_POST['prenom'] ?? '');
    $date_naissance = $_POST['date_naissance'] ?? '';
    $sexe           = $_POST['sexe'] ?? '';
    $lieu           = trim($_POST['lieu_naissance'] ?? '');
    $filiere_id     = $_POST['filiere'] ?? '';

    if ($matricule && $nom && $prenom && $date_naissance && $sexe && $lieu && $filiere_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO etudiants (matricule, nom, prenom, date_naissance, sexe, lieu_naissance, filiere_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$matricule, $nom, $prenom, $date_naissance, $sexe, $lieu, $filiere_id]);
            header('Location: ajouter_etudiant.php?success=1');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // Contrainte d'unicité violée
                $error = "Un étudiant avec ces informations existe déjà.";
            } else {
                $error = "Erreur lors de l'ajout de l'étudiant : " . $e->getMessage();
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ Ajouter un Étudiant | PrintCF</title>
    <!-- Assurez-vous de lier LE MÊME fichier CSS que pour les autres pages -->
    <link rel="stylesheet" href="s.css"> 
</head>
<body>

    <main class="content-wrapper">
        <div class="form-container">
            <!-- Titre amélioré pour plus de style -->
            <h1>
                <span class="title-icon">➕</span>
                <span class="title-main">Ajouter un Nouvel <span class="title-highlight">Étudiant</span></span>
            </h1>
            
            <a href="index.php" class="back-link">⬅ Retour au Dashboard</a>

<?php if (isset($_GET['success'])): ?>
    <p class="success-msg">✅ Étudiant ajouté avec succès.</p>
<?php elseif (!empty($error)): ?>
    <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

            <form method="post" class="add-form">
                <!-- Chaque groupe label/input est dans un div pour la grille CSS -->
                <div class="form-group">
                    <label for="matricule">Matricule</label>
                    <input type="text" id="matricule" name="matricule" required placeholder="Ex: 2023CF001">
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required placeholder="Ex: Dupont">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required placeholder="Ex: Jean">
                </div>
                <div class="form-group">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" required>
                </div>
                <div class="form-group">
                    <label for="sexe">Sexe</label>
                    <select id="sexe" name="sexe" required>
                        <option value="" disabled selected>-- Choisir --</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lieu_naissance">Lieu de naissance</label>
                    <input type="text" id="lieu_naissance" name="lieu_naissance" required placeholder="Ex: Paris">
                </div>
                <div class="form-group">
                    <label for="filiere">Filière</label>
                    <select id="filiere" name="filiere" required>
                    <option value="" disabled selected>-- selectionner --</option>
                        <option value="I"> ICT4D </option>
                        <option value="F">Informatique Fondamentale </option>
                        <?php foreach ($filieres as $filiere): ?>
                            <option value="<?= htmlspecialchars($filiere['id']) ?>"><?= htmlspecialchars($filiere['nom_filiere']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="submit-btn">💾 Enregistrer l'étudiant</button>
            </form>
        </div>
    </main>

</body>
</html>