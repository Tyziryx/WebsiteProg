# Cahier des Charges pour le Site Web

## Contexte et Objectif
Le but de ce projet est de développer un site web fonctionnel en PHP avec une base de données PostgreSQL. Le site doit inclure deux parties principales : un **Front Office** accessible par tous les utilisateurs et un **Back Office** réservé à l'administration du site.

Le site web doit être conçu pour être disponible et opérationnel sur un espace pédagogique, sans framework PHP ni CMS. Il doit inclure une structure claire et des fonctionnalités qui permettent à l’administrateur de gérer les utilisateurs et les données principales.

---

## 1. Technologies Utilisées
- **Côté serveur :**
  - PHP 
  - PostgreSQL (base de données)
  - Pedago (serveur web)

- **Côté client :**
  - HTML, CSS 
  - JavaScript 
  
---

## 2. Arborescence et Structure du Site

Le site web sera composé de deux parties principales :
- **Front Office** : accessible à tous les utilisateurs.
- **Back Office** : accessible uniquement aux administrateurs du site.

### Arborescence du Site :

- **Front Office :**
  - `index.php` : Page d'accueil avec présentation du site.
  - `contact.php` : Formulaire de contact.
  - `faq.php` : Page de questions/réponses.

- **Back Office :**
  - `admin_login.php` : Page de connexion à l'administration.
  - `dashboard.php` : Tableau de bord de l’administrateur avec résumé des activités et accès aux différentes sections.
  - `manage_data.php` : Page permettant de gérer les données principales (ajout/suppression).
  - `manage_users.php` : Gestion des utilisateurs (ajouter/supprimer/modifier des comptes utilisateurs).
  - `faq.php` : Page de gestion des questions fréquemment posées.

 - **GéoDex :**
  - `index.php` : Page d'accueil ( ouverture géode )
  - `GeoDex.php` : Page permettant de consulter le géodex
  - `login.php` : Page de connexion des utilisateurs.
  - `profile.php` : Page de profil utilisateur (accessible après connexion).
---

## 3. Fonctionnalités

### Front Office
1. **Page de présentation (`index.php`) :**
   - Présentation des pierres avec menu déroulant static.
   - Structure claire avec en-tête, menu de navigation, et contenu principal.

2. **Formulaire de contact (`contact.php`) :**
   - Permet aux utilisateurs de contacter l'administrateur via un formulaire.
   - Champs requis : Nom, Email, Message.
   - Validation des données avant envoi.
   - Envoi de l’email via PHP mail() ou autre méthode sécurisée.

3. **Page de login / Profil utilisateur (`login.php` / `profile.php`) :**
   - Connexion utilisateur via un formulaire de login.
   - Gestion de session pour maintenir l'utilisateur connecté.
   - Page de profil affichant les informations de l'utilisateur après connexion (modifiables).
  
4. **Page FAQ (`faq.php`) :**
   - Affiche les questions réponses fréquemment poser. 
  
   

### Back Office
1. **Page de login administrateur (`admin_login.php`) :**
   - Connexion à l'interface d'administration via un formulaire sécurisé.
   - Gestion des erreurs et sécurité (par exemple, hachage du mot de passe avec PHP).

2. **Tableau de bord administrateur (`dashboard.php`) :**
   - Vue d’ensemble des actions récentes.
   - Accès aux pages de gestion des données et des utilisateurs.

3. **Gestion des données principales (`manage_data.php`) :**
   - Affichage des données principales stockées dans la base de données.
   - Options pour ajouter, modifier ou supprimer des éléments dans GéoDex ou dans la page principale.
   - Requêtes sécurisées pour éviter les injections SQL.

4. **Gestion des utilisateurs (`manage_users.php`) :**
   - Liste des utilisateurs enregistrés.
   - Options pour ajouter, modifier ou supprimer des utilisateurs.
   - Gestion des rôles (utilisateur/admin).

5. **Page FAQ (`faq.php`) :**
   - Interface permettant à l’administrateur d’ajouter, modifier ou supprimer des questions et réponses fréquemment posées.

---

## 4. Base de Données PostgreSQL

(A FAIRE )


## 5. Sécurité
- Authentification des utilisateurs avec validation des mots de passe.
- Utilisation de sessions PHP pour gérer les connexions.
((- Protection contre les injections SQL via des requêtes préparées.))

---


## 6. Livrables
- Le code complet du site web hébergé sur l’espace pédagogique.
- Un **manuel d’utilisation** pour l’administrateur, expliquant comment utiliser chaque fonction du site (connexion, gestion des données, gestion des utilisateurs, etc.).
- Un **manuel d’utilisation** pour le client, expliquant comment utiliser chaque fonction du site .

