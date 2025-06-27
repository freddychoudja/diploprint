<?php
// 1. Démarrage et sécurité
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . '/includes/header.php';
// 2. Connexion et récupération des données
require 'connexion.php';

try {
    // La requête SQL pour trouver les étudiants avec au moins une pièce manquante ou non validée
    $query = "
        SELECT e.id, e.matricule, e.nom, e.prenom, f.nom_filiere
        FROM etudiants e
        JOIN filieres f ON e.filiere_id = f.id
        WHERE EXISTS (
            SELECT 1 FROM pieces p
            LEFT JOIN etudiant_piece ep ON ep.id_piece = p.id AND ep.id_etudiant = e.id
            WHERE ep.id IS NULL OR ep.statut = 0
        )
        ORDER BY e.nom ASC, e.prenom ASC
    ";
    
    $stmt = $pdo->query($query);
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dossiers Incomplets | PrintCF</title>
    <link rel="stylesheet" href="s.css">
    
    <!-- === SECTION CORRIGÉE === -->
    <!-- Script 1 : jsPDF Core v2.5.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- Script 2 : jsPDF AutoTable v3.8.2 (Version compatible) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.js"></script>
    <!-- ========================== -->

</head>
<body>

    <main class="content-wrapper">
        <div class="page-container"> 
            <h1>📄 Étudiants avec Dossier Incomplet</h1>
            <a href="index.php" class="back-link">⬅ Retour au Dashboard</a>

            <?php if (count($etudiants) > 0): ?>
                <table id="students-table">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Filière</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($etudiants as $etudiant): ?>
                            <tr>
                                <td><?= htmlspecialchars($etudiant['matricule']) ?></td>
                                <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                                <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                                <td><?= htmlspecialchars($etudiant['nom_filiere']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="download-btn" onclick="generatePDF()">Télécharger la liste en PDF</button>
            <?php else: ?>
                <p class="no-results">✅ Bonne nouvelle ! Aucun dossier incomplet n'a été trouvé.</p>
            <?php endif; ?>
        </div>
    </main>

<!-- === SCRIPT AMÉLIORÉ ET ADAPTÉ === -->
<script>
function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
   
    doc.setFont('helvetica');

    // Définition des variables pour une maintenance facile
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const margin = 15;
    const title = "Liste des Étudiants avec Dossier Incomplet"; // Titre adapté
    const generatedDate = `Généré le : ${new Date().toLocaleDateString('fr-FR')}`;

    // Utilisation de autoTable avec la gestion des en-têtes/pieds de page
    doc.autoTable({
        html: '#students-table',
        startY: margin + 15,
        margin: { top: margin + 10 },
        theme: 'grid',
        headStyles: { 
            fillColor: [0, 212, 192],
            textColor: [255, 255, 255],
            fontStyle: 'bold',
            halign: 'center'
        },
        styles: {
            font: 'helvetica', 
            fontSize: 9,
            cellPadding: 2,
        },
        alternateRowStyles: {
            fillColor: [245, 245, 245]
        },
        // Fonction qui dessine l'en-tête et le pied de page sur CHAQUE page
        didDrawPage: function (data) {
            // En-tête de page
            doc.setFontSize(18);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(40);
            doc.text(title, pageWidth / 2, margin, { align: 'center' });

            // Pied de page
            doc.setFontSize(10);
            doc.setFont('helvetica', 'italic');
            
            const pageCount = doc.internal.getNumberOfPages();
            const pageNumText = `Page ${data.pageNumber} sur ${pageCount}`;
            doc.text(pageNumText, pageWidth - margin, pageHeight - 10, { align: 'right' });
            
            doc.text(generatedDate, margin, pageHeight - 10);
        }
    });

    // Sauvegarde avec un nom de fichier dynamique et adapté
    const dateStr = new Date().toISOString().split('T')[0];
    doc.save(`liste_dossiers_incomplets_${dateStr}.pdf`);
}
</script>

</body>
</html>