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
// Configuration session IDENTIQUE à login.php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/geodex/app',
    'domain' => 'tyzi.fr',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

// Destruction complète de la session
$_SESSION = [];
session_unset();
session_destroy();

// Suppression des cookies AVEC LES MÊMES PARAMÈTRES
$cookieOptions = [
    'expires' => time() - 3600,
    'path' => '/geodex/app',
    'domain' => 'tyzi.fr',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
];

setcookie('session_user', '', $cookieOptions);
setcookie('session_date', '', $cookieOptions);
setcookie(session_name(), '', $cookieOptions); // Supprime le cookie de session PHP

// Redirection ABSOLUE
header("Location: https://tyzi.fr/geodex/app/?page=login");
exit;
?>