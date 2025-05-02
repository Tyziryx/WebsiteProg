<?php

/**
 * Script de déconnexion de l'utilisateur.
 * 
 * Ce script permet à l'utilisateur de se déconnecter en détruisant la session active.
 * Après avoir détruit la session, il redirige l'utilisateur vers la page d'accueil.
 * 
 * @package Déconnexion
 */

// Démarre la session si elle n'est pas déjà active
$_SESSION = array();
session_unset();
session_destroy();

// Suppression cookies avec chemin ABSOLU
setcookie('session_user', '', time() - 3600, '/geodex/app', $domain = 'tyzi.fr', $secure = true);
setcookie('session_date', '', time() - 3600, '/geodex/app', $domain = 'tyzi.fr', $secure = true);

// Redirection ABSOLUE HTTPS
header("Location: https://tyzi.fr/geodex/app/login");
exit;
?>