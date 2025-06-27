# PrintCF – Plateforme de gestion des dossiers de diplomation

Bienvenue dans **PrintCF**, une application PHP permettant aux établissements académiques de gérer, suivre et valider les dossiers de diplomation des étudiants.

---

## Sommaire
1. Présentation
2. Fonctionnalités clés
3. Architecture & technologies
4. Installation locale
5. Configuration de la base de données
6. Structure du projet
7. Guides d’utilisation
8. Déploiement (optionnel)
9. Auteurs & licence

---

## 1. Présentation
PrintCF centralise toutes les informations relatives aux étudiants, aux pièces justificatives requises pour la diplomation et à leur statut (complet / incomplet). L’interface responsive offre un thème sombre moderne (Glassmorphism) grâce au fichier `s.css`.

## 2. Fonctionnalités clés
* Inscription / connexion sécurisée (hash BCrypt, sessions PHP).
* Tableau de bord personnalisé après connexion.
* Ajout d’étudiants, mise à jour des informations et des pièces.
* Listings filtrés :
  * Dossiers **complets**
  * Dossiers **incomplets**
* Export PDF des listes via **jsPDF + AutoTable**.
* Filtrage par filière.
* Redirection automatique vers la page d’inscription si aucun compte administrateur n’existe.

## 3. Architecture & technologies
| Couche | Stack |
|--------|-------|
| Back-end | PHP ≥ 7.4, PDO, MySQL |
| Front-end | HTML5, SCSS-like CSS (fichier `s.css`), Google Fonts (Poppins) |
| JS | jsPDF 2.x, jspdf-autotable 3.x |

Tous les accès BD passent par `includes/config.php` qui instancie `$pdo` et démarre la session.

## 4. Installation locale
1. Pré-requis : **PHP**, **MySQL/MariaDB** (ex. XAMPP ou Wamp).
2. Clone ou copie du dossier `bd/` dans `htdocs`.
3. Crée la BD :
   ```sql
   CREATE DATABASE projet_diplomation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
4. Importe le schéma (tables `users`, `etudiants`, `filieres`, `pieces`, `etudiant_piece`).
5. Mets à jour les identifiants BD dans `includes/config.php` si nécessaire.
6. Lance Apache & MySQL puis ouvre `http://localhost/bd/home.php`.

## 5. Configuration de la base de données
Le fichier `schema.sql` (à créer si nécessaire) doit contenir :
```sql
-- Exemple minimal
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  mot_de_passe VARCHAR(255)
);
-- Autres tables…
```
> Remarque : des contraintes d’intégrité référentielle sont recommandées (FOREIGN KEY).

## 6. Structure du projet
```
bd/
├─ includes/
│  ├─ config.php        # Connexion PDO centrale
│  ├─ header.php        # <head> + nav
│  └─ footer.php        # <footer>
├─ s.css                # Feuille de style principale (responsive)
├─ index.php            # Dashboard
├─ home.php             # Landing / redirections
├─ login.php            # Authentification
├─ register.php         # Inscription
├─ ajouter_etudiant.php # Ajout étudiant
├─ update_etudiant.php  # MAJ profil & pièces
├─ liste_complets.php   # Liste dossiers complets
├─ liste_incomplets.php # Liste dossiers incomplets
└─ README.txt           # Ce fichier
```

## 7. Guides d’utilisation
* **Première utilisation** : accède à `/bd/home.php`. S’il n’existe aucun utilisateur, tu es redirigé vers l’inscription.
* **Ajout d’une filière ou d’une pièce** : ajoute-les directement en BD (administration simplifiée à prévoir).
* **Gestion des pièces** : dans *Mise à jour*, coche/décoche les pièces pour marquer un dossier complet.
* **Export PDF** : clique sur « Télécharger la liste en PDF » dans les pages de listes.

## 8. Déploiement (optionnel)
L’application peut être déployée sur n’importe quel hébergeur LAMP. Assure-toi de :
1. Copier tous les fichiers dans le répertoire web.
2. Importer la base de données.
3. Mettre à jour les credentials dans `includes/config.php`.

## 9. Auteurs & licence
Projet développé par PRINTCF.

Code publié sous licence MIT. N’hésitez pas à contribuer ou à signaler des issues !
