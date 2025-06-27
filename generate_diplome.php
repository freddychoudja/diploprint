<?php
// 1. DÉMARRAGE ET SÉCURITÉ
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require 'connexion.php';

// 2. VALIDATION DE L'ENTRÉE (ID DE L'ÉTUDIANT)
// On s'assure que l'ID est présent et est un nombre entier positif
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Erreur : ID de l'étudiant invalide ou manquant.");
}
$id = (int)$_GET['id'];

try {
    // 3. VÉRIFICATION DE SÉCURITÉ : LE DOSSIER EST-IL VRAIMENT COMPLET ?
    // C'est une étape cruciale pour empêcher un utilisateur de taper l'URL manuellement
    $checkQuery = "SELECT COUNT(1)
                   FROM pieces p
                   LEFT JOIN etudiant_piece ep ON ep.id_piece = p.id AND ep.id_etudiant = ?
                   WHERE ep.id IS NULL OR ep.statut = 0";
    $stmtCheck = $pdo->prepare($checkQuery);
    $stmtCheck->execute([$id]);
    $piecesManquantes = $stmtCheck->fetchColumn();

    if ($piecesManquantes > 0) {
        // Si le dossier n'est pas complet, on bloque la génération du diplôme.
        die("Accès refusé : Le dossier de cet étudiant n'est pas complet.");
    }

    // 4. RÉCUPÉRATION DES INFORMATIONS COMPLÈTES DE L'ÉTUDIANT
    // Le dossier est complet, on peut maintenant récupérer les infos pour le diplôme
    $query = "SELECT e.matricule, e.nom, e.prenom, f.nom_filiere 
              FROM etudiants e 
              JOIN filieres f ON e.filiere_id = f.id 
              WHERE e.id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        die("Erreur : Étudiant non trouvé.");
    }

} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}

// 5. PRÉPARATION DES DONNÉES POUR JAVASCRIPT
// json_encode est la meilleure façon de passer des données PHP à JavaScript de manière sûre
$donneesEtudiantPourJS = json_encode([
    'nomComplet' => mb_strtoupper($etudiant['nom']) . ' ' . $etudiant['prenom'], // En majuscules pour un style officiel
    'nomFiliere' => $etudiant['nom_filiere'],
    'matricule'  => $etudiant['matricule'],
]);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Génération de l'attestation...</title>
    <!-- On a juste besoin de la bibliothèque jsPDF de base, pas de autoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body { font-family: sans-serif; background-color: #f0f2f5; text-align: center; padding-top: 50px; }
        p { font-size: 1.2em; }
    </style>
</head>
<body>
    <p>Génération de votre attestation en cours...</p>
    <p>Le téléchargement démarrera automatiquement.</p>

<script>
    // Cette fonction s'exécute dès que la page est chargée
    window.onload = function() {
        const { jsPDF } = window.jspdf;
        // On récupère les données de l'étudiant envoyées par PHP
        const etudiant = <?= $donneesEtudiantPourJS ?>;

        // Création du document en mode PAYSAGE (landscape), plus adapté pour un diplôme
        const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });

        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const margin = 20;

        // --- DÉBUT DE LA CRÉATION DU DESIGN DE L'ATTESTATION ---

        // 1. Cadre décoratif
        doc.setLineWidth(1.5);
        doc.setDrawColor(0, 82, 163); // Un bleu marine sobre
        doc.rect(margin / 2, margin / 2, pageWidth - margin, pageHeight - margin);

        // 2. Logo (Optionnel)
        // doc.addImage('chemin/vers/votre/logo.png', 'PNG', margin, margin, 40, 20);

        // 3. Titre Principal
        doc.setFont('times', 'bold');
        doc.setFontSize(32);
        doc.setTextColor(0, 82, 163);
        doc.text("ATTESTATION DE RÉUSSITE", pageWidth / 2, margin + 25, { align: 'center' });

        // 4. Texte d'introduction
        doc.setFont('times', 'normal');
        doc.setFontSize(14);
        doc.setTextColor(0, 0, 0);
        doc.text("Le Jury de l'établissement PRINTCF certifie que :", pageWidth / 2, margin + 50, { align: 'center' });

        // 5. Nom de l'étudiant (bien en évidence)
        doc.setFont('times', 'bold');
        doc.setFontSize(26);
        doc.setTextColor(204, 102, 0); // Une couleur "or"
        doc.text(etudiant.nomComplet, pageWidth / 2, margin + 70, { align: 'center' });

        // 6. Détails de la formation
        doc.setFont('times', 'normal');
        doc.setFontSize(14);
        doc.setTextColor(0, 0, 0);
        const texteFormation = `A complété avec succès le programme de formation en :`;
        const texteFiliere = etudiant.nomFiliere;
        
        doc.text(texteFormation, pageWidth / 2, margin + 90, { align: 'center' });
        doc.setFont('times', 'bold');
        doc.setFontSize(18);
        doc.text(texteFiliere, pageWidth / 2, margin + 100, { align: 'center' });


        // 7. Date et lieu
        const dateDuJour = new Date().toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
        doc.setFont('times', 'normal');
        doc.setFontSize(12);
        doc.text(`Fait à Yaoundé, le ${dateDuJour}`, pageWidth - margin, pageHeight - margin - 30, { align: 'right' });


        // 8. Signatures
        doc.setLineWidth(0.5);
        doc.line(margin, pageHeight - margin - 15, margin + 60, pageHeight - margin - 15);
        doc.text("Le Directeur de l'établissement", margin, pageHeight - margin - 10);
        
        doc.line(pageWidth - margin - 60, pageHeight - margin - 15, pageWidth - margin, pageHeight - margin - 15);
        doc.text("Le Président du Jury", pageWidth - margin, pageHeight - margin - 10, { align: 'right' });
        

        // --- FIN DU DESIGN ---

        // 9. Sauvegarde du fichier
        const nomFichier = `Attestation_${etudiant.nomComplet.replace(/ /g, '_')}.pdf`;
        doc.save(nomFichier);

        // Optionnel : rediriger l'utilisateur après un court instant
        setTimeout(() => {
            window.location.href = 'espace_etudiant.php?etudiant_id=' + <?= $id ?>;
        }, 3000);
    };
</script>

</body>
</html>