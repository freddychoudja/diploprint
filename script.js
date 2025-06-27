/**
 * Génère un document PDF à partir du contenu de la page.
 * Cette version est structurée, gère les sauts de page,
 * et ajoute un en-tête et un pied de page sur chaque page.
 */
function generatePDF() {
    // S'assurer que la librairie jsPDF est chargée
    if (!window.jspdf || !window.jspdf.jsPDF) {
        console.error("La librairie jsPDF n'est pas chargée.");
        return;
    }
    const { jsPDF } = window.jspdf;

    // 1. Initialisation du document avec des paramètres clairs
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4'
    });

    // 2. Définition des constantes pour la mise en page
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const margin = 15; // Marge uniforme
    const contentWidth = pageWidth - margin * 2; // Largeur disponible pour le contenu
    const lineHeight = 7; // Hauteur de ligne pour le texte (interligne)

    // --- Fonctions utilitaires pour l'en-tête et le pied de page ---

    /**
     * Ajoute l'en-tête sur la page actuelle.
     * @returns {number} La position Y (curseur) pour commencer le contenu.
     */
    const addHeader = () => {
        doc.setFontSize(18);
        doc.setFont('helvetica', 'bold');
        doc.text('Application de Gestion de Diplomation', pageWidth / 2, margin + 5, { align: 'center' });

        // Ligne de séparation
        doc.setDrawColor(0, 212, 192); // Une couleur "teal"
        doc.setLineWidth(0.5);
        doc.line(margin, margin + 10, pageWidth - margin, margin + 10);

        // Retourne la position Y où le contenu doit commencer
        return margin + 20;
    };

    /**
     * Ajoute le pied de page (date et numéro de page) sur la page actuelle.
     * Doit être appelée dans une boucle après la création de toutes les pages.
     * @param {number} pageNum - Le numéro de la page actuelle.
     * @param {number} totalPages - Le nombre total de pages.
     */
    const addFooter = (pageNum, totalPages) => {
        const footerY = pageHeight - margin;
        doc.setFontSize(10);
        doc.setFont('helvetica', 'italic');

        // Date de génération à gauche
        doc.text(`Généré le : ${new Date().toLocaleDateString('fr-FR')}`, margin, footerY);

        // Numéro de page à droite
        doc.text(`Page ${pageNum} / ${totalPages}`, pageWidth - margin, footerY, { align: 'right' });
    };


    // --- Génération du contenu ---

    // 3. Ajout de l'en-tête sur la première page
    let cursorY = addHeader();

    // 4. Récupération et préparation du contenu principal
    const section = document.getElementById('main-content');
    const contentText = section ? section.innerText.trim() : 'Aucun contenu trouvé dans la section #main-content.';
    
    // Découpe le texte en lignes qui respectent la largeur du contenu
    const wrappedLines = doc.splitTextToSize(contentText, contentWidth);

    // Sous-titre
    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    doc.text('Résumé des informations :', margin, cursorY);
    cursorY += lineHeight * 2; // Espace après le sous-titre

    // 5. Ajout du contenu ligne par ligne avec gestion des sauts de page
    wrappedLines.forEach(line => {
        // Vérifie si la prochaine ligne dépasse la zone d'écriture (avant le pied de page)
        if (cursorY + lineHeight > pageHeight - margin) {
            doc.addPage();
            cursorY = addHeader(); // Ajoute l'en-tête sur la nouvelle page et réinitialise le curseur
        }
        doc.text(line, margin, cursorY);
        cursorY += lineHeight; // Déplace le curseur vers le bas pour la prochaine ligne
    });


    // --- Finalisation ---

    // 6. Ajout des pieds de page sur toutes les pages
    // Cette boucle est essentielle : elle s'exécute APRES que toutes les pages aient été créées.
    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i); // Active la page 'i' pour y dessiner
        addFooter(i, pageCount);
    }

    // 7. Sauvegarde du fichier PDF
    doc.save('Gestion_Diplomation_Resume.pdf');
}