# Cahier des Charges pour le Site Web

## Contexte et Objectif
Le but de ce projet est de développer un site web fonctionnel en PHP avec une base de données PostgreSQL. Le site doit inclure deux parties principales : un **Front Office** accessible par tous les utilisateurs et un **Back Office** réservé à l'administration du site. Dans le cadre de notre projet, la partie Front Office est divisée en deux parties, une "statique" de présentation rapide puis une plus "dynamique" qui est accessible en se connectant. 

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
  - `index.php` : Page d'accueil (ouverture géode)
  - `GeoDex.php` : Page permettant de consulter le géodex
  - `login.php` : Page de connexion des utilisateurs.
  - `profile.php` : Page de profil utilisateur (accessible après connexion).
---
Lien vers witheboard contenant la structure des pages du site:
https://wbd.ms/share/v2/aHR0cHM6Ly93aGl0ZWJvYXJkLm1pY3Jvc29mdC5jb20vYXBpL3YxLjAvd2hpdGVib2FyZHMvcmVkZWVtL2ZmZDgwZTMyNmVlZjRkNDNhM2M2ZjIwN2NiMGM1YWFkX0JCQTcxNzYyLTEyRTAtNDJFMS1CMzI0LTVCMTMxRjQyNEUzRF9iZWQ4NDgyOC04NjhkLTQ1ZmItODc1NC1iMDc0MmE3ZjBjYzY=

## 3. Fonctionnalités

### Front Office
#### Accueil
1. **Page de présentation (`index.php`) :**
   - Présentation des pierres avec menu déroulant static.
   - Structure claire avec menu de navigation, et contenu principal.

2. **Formulaire de contact (`contact.php`) :**
   - Permet aux utilisateurs de contacter l'administrateur via un formulaire.
   - Champs requis : Nom, Email, Message.
   - Validation des données avant envoi.
   - Envoi de l’email via PHP mail() ou autre méthode sécurisée.
  
4. **Page FAQ (`faq.php`) :**
   - Affiche les questions des réponses fréquemment poser par les utilisateurs.
  
#### Application (Géodex)
  
1. **Page de login (`login.php`) :**
   - Connexion utilisateur via un formulaire de login.
   - Gestion de session pour maintenir l'utilisateur connecté.
  
2. **Page de profil (`profil.php`)**
   - Page de profil affichant les informations de l'utilisateur après connexion (modifiables).

3. **Accueil (`dashboard.php`)**
   - Page permettant de tirer au sort une pierre par jour pour l'ajouter à son géodex.

4. **Géodex (`geodex.php`)**
   - Page qui permet de voir notre collection de pierres (obtenue ou pas obtenue).
   - requête GET en cliquant sur l'image afin d'avoir plus d'information sur une pierre


### Back Office
1. **Page de login administrateur (`login.php`) :**
   - Connexion à l'interface d'administration via un formulaire sécurisé.
   - Gestion des erreurs et sécurité (par exemple, hachage du mot de passe avec PHP).

2. **Gestion des utilisateurs (`manage_users.php`) :**
   - Tableau affichant les attributs des utilisateurs.
   - Bouton pour modifier, supprimer ou ajouter un utilisateur.
   - Gestion des rôles (utilisateur ou admin)

3. **Gestion des données principales (`manage_home.php`) :**
   - Tableau affichant les données des pierres de l'accueil.
   - Possibilité de les modifier (nom, image, description).

4. **Gestion des utilisateurs (`manage_geodex.php`) :**
   - Tableau avec les pierres déblocables dans géodex.
   - Possibilité d'ajouter, de modifier ou de supprimer des utilisateurs.

5. **Gestion de la FAQ des utilisateurs (`manage_faq.php`) :**
   - Interface permettant à l’administrateur d’ajouter, modifier ou supprimer des questions et réponses fréquemment posées par les utilisateurs.
  
5. **Page FAQ (`faq.php`) :**
   - FAQ pour répondres aux questions des futurs admin sur le fonctionnement du Back Office.

---

## 4. Base de Données PostgreSQL

![image](https://github.com/user-attachments/assets/254a94f4-689d-449b-87b1-178d64140adc)


## 5. Sécurité
- Authentification des utilisateurs avec validation des mots de passe.
- Utilisation de sessions PHP pour gérer les connexions.
((- Protection contre les injections SQL via des requêtes préparées.))

---


## 6. Livrables
- Le code complet du site web hébergé sur l’espace pédagogique.
- Une **FAQ** pour l’administrateur, expliquant comment utiliser chaque fonction du site (connexion, gestion des données, gestion des utilisateurs, etc.).
- Une **FAQ** pour le client, expliquant comment utiliser chaque fonction du site.

