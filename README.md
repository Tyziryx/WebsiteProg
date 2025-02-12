# Cahier des Charges pour le Site Web

## Contexte et Objectif
Le but de ce projet est de développer un site web fonctionnel en PHP avec une base de données PostgreSQL. Le site doit inclure deux parties principales : un **Front Office** accessible par tous les utilisateurs et un **Back Office** réservé à l'administration du site.

Le site web doit être conçu pour être disponible et opérationnel sur un espace pédagogique, sans framework PHP ni CMS. Il doit inclure une structure claire et des fonctionnalités qui permettent à l’administrateur de gérer les utilisateurs et les données principales.

---

## 1. Technologies Utilisées
- **Côté serveur :**
  - PHP (sans framework ni CMS)
  - PostgreSQL (base de données)
  - Apache (serveur web)

- **Côté client :**
  - HTML, CSS (choix de la méthode à justifier)
  - JavaScript (si nécessaire pour des interactions dynamiques)
  
---

## 2. Arborescence et Structure du Site

Le site web sera composé de deux parties principales :
- **Front Office** : accessible à tous les utilisateurs.
- **Back Office** : accessible uniquement aux administrateurs du site.

### Arborescence du Site :

- **Front Office :**
  - `index.php` : Page d'accueil avec présentation du site.
  - `contact.php` : Formulaire de contact.
  - `data.php` : Page dynamique affichant les données principales (ex. produits, services, etc.).
  - `login.php` : Page de connexion des utilisateurs.
  - `profile.php` : Page de profil utilisateur (accessible après connexion).

- **Back Office :**
  - `admin_login.php` : Page de connexion à l'administration.
  - `dashboard.php` : Tableau de bord de l’administrateur avec résumé des activités et accès aux différentes sections.
  - `manage_data.php` : Page permettant de gérer les données principales (ajout/suppression).
  - `manage_users.php` : Gestion des utilisateurs (ajouter/supprimer/modifier des comptes utilisateurs).
  - `faq.php` : Page de gestion des questions fréquemment posées.

---

## 3. Fonctionnalités

### Front Office
1. **Page de présentation (`index.php`) :**
   - Présentation du site, de ses services ou de son entreprise.
   - Structure claire avec en-tête, menu de navigation, et contenu principal.

2. **Formulaire de contact (`contact.php`) :**
   - Permet aux utilisateurs de contacter l'administrateur via un formulaire.
   - Champs requis : Nom, Email, Message.
   - Validation des données avant envoi.
   - Envoi de l’email via PHP mail() ou autre méthode sécurisée.

3. **Page dynamique (`data.php`) :**
   - Affichage des données principales sous forme de liste ou tableau.
   - Les données seront récupérées depuis la base de données PostgreSQL.
   - Affichage dynamique avec des requêtes SQL en PHP.

4. **Page de login / Profil utilisateur (`login.php` / `profile.php`) :**
   - Connexion utilisateur via un formulaire de login.
   - Gestion de session pour maintenir l'utilisateur connecté.
   - Page de profil affichant les informations de l'utilisateur après connexion (modifiables).

### Back Office
1. **Page de login administrateur (`admin_login.php`) :**
   - Connexion à l'interface d'administration via un formulaire sécurisé.
   - Gestion des erreurs et sécurité (par exemple, hachage du mot de passe avec PHP).

2. **Tableau de bord administrateur (`dashboard.php`) :**
   - Vue d’ensemble des actions récentes.
   - Accès aux pages de gestion des données et des utilisateurs.

3. **Gestion des données principales (`manage_data.php`) :**
   - Affichage des données principales stockées dans la base de données.
   - Options pour ajouter, modifier ou supprimer des éléments.
   - Requêtes sécurisées pour éviter les injections SQL.

4. **Gestion des utilisateurs (`manage_users.php`) :**
   - Liste des utilisateurs enregistrés.
   - Options pour ajouter, modifier ou supprimer des utilisateurs.
   - Gestion des rôles (utilisateur/admin).

5. **Page FAQ (`faq.php`) :**
   - Interface permettant à l’administrateur d’ajouter, modifier ou supprimer des questions et réponses fréquemment posées.

---

## 4. Base de Données PostgreSQL

Le site doit être alimenté par une base de données PostgreSQL. Les tables suivantes devront être créées :
- **Utilisateurs :**
  - ID (clé primaire)
  - Nom, Email, Mot de passe (haché)
  - Rôle (utilisateur/admin)
  
- **Données principales :**
  - ID (clé primaire)
  - Titre, Description, Date de création
  - Autres champs selon les besoins du site (ex. image, prix, etc.)

- **FAQ :**
  - ID (clé primaire)
  - Question
  - Réponse

---

## 5. Sécurité
- Authentification des utilisateurs avec validation des mots de passe.
- Utilisation de sessions PHP pour gérer les connexions.
- Protection contre les injections SQL via des requêtes préparées.
- Validation des données côté client et serveur.

---

## 6. Conception Visuelle (CSS)
Le choix du CSS est laissé libre, mais il faudra justifier la méthode choisie (par exemple, en utilisant un framework CSS comme Bootstrap ou en écrivant un CSS personnalisé).

---

## 7. Livrables
- Le code complet du site web hébergé sur l’espace pédagogique.
- Un **manuel d’utilisation** pour l’administrateur, expliquant comment utiliser chaque fonction du site (connexion, gestion des données, gestion des utilisateurs, etc.).

---

## 8. Planning
Le projet sera divisé en plusieurs étapes :
1. **Phase 1 :** Création de la structure de base (front office + back office).
2. **Phase 2 :** Mise en place de la base de données et gestion des données.
3. **Phase 3 :** Intégration du formulaire de contact et gestion des utilisateurs.
4. **Phase 4 :** Finalisation du back office et de la gestion des FAQ.
5. **Phase 5 :** Tests, débogage et livraison.

---

## 9. Validation
Le site sera testé sur l’espace pédagogique pour s'assurer qu’il respecte les critères de fonctionnalité, de sécurité et d’ergonomie définis dans ce cahier des charges.
