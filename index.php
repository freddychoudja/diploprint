<?php
// ... votre code PHP au début ...
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/connexion.php';
$pageTitle = 'Dashboard';

$stmt = $pdo->query("SELECT * FROM filieres ORDER BY nom_filiere");
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Le header.php va générer le <head> et le <header> HTML
require_once __DIR__ . '/includes/header.php'; 
?>

<!-- Le corps de la page est maintenant dans un wrapper standard -->
<main class="content-wrapper">

    <!-- On utilise un conteneur spécifique pour le dashboard -->
    <div class="dashboard-panel">
        
        <div class="dashboard-intro">
            <img src="photo.jpg" alt="Photo de profil" class="profile-img" />
            <div class="intro-text">
                <h2>Bienvenue, <?= htmlspecialchars($_SESSION['user']['prenom'] ?? 'Admin') ?> !</h2>
                <p>Que souhaitez-vous faire aujourd'hui ?</p>
            </div>
        </div>

        <form action="" method="get" class="filiere-form">
            <label for="filiere">Filtrer les listes par filière :</label>
            <div class="select-wrapper">
                <select name="filiere" id="filiere">
                    <option value="">Toutes les filières</option>
                    <?php foreach($filieres as $filiere): ?>
                        <option value="<?= $filiere['id'] ?>"><?= htmlspecialchars($filiere['nom_filiere']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
       </form>

        <!-- Recherche par matricule -->
        <form action="rechercher_etudiant.php" method="get" class="search-matricule-form" style="margin-top:1rem;">
            <label for="matricule_search">Recherche par matricule :</label>
            <input type="text" name="q" id="matricule_search" placeholder="2023CF001" required style="margin:0 8px;">
            <button type="submit" class="submit-btn">🔍</button>
        </form>

        <div class="actions">
            <a href="liste_complets.php" class="action"><span>📋</span> Dossiers Complets</a>
            <a href="liste_incomplets.php" class="action"><span>📄</span> Dossiers Incomplets</a>
            <a href="update_etudiant.php" class="action"><span>✏️</span> Mettre à jour</a>
            <a href="espace_etudiant.php" class="action"><span>🎓</span> Espace Étudiant</a>
            <a href="ajouter_etudiant.php" class="action"><span>✨</span> Ajouter Étudiant</a>
        </div>

    </div>
</main>

<?php 
// Le footer.php va générer le <footer> et fermer les balises body/html
require_once __DIR__ . '/includes/footer.php'; 
?>