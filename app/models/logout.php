<?php

/**
 * Script de déconnexion de l'utilisateur.
 * 
 * Ce script permet à l'utilisateur de se déconnecter en détruisant la session active.
 * Après avoir détruit la session, il redirige l'utilisateur vers la page d'accueil.
 * 
 * @package Déconnexion
 */

// Configuration de la session sécurisée
session_name('TYZISESSID');
session_set_cookie_params([
    'lifetime' => 86400 * 30,
    'path' => '/',
    'domain' => '.tyzi.fr',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Détruire proprement la session
session_unset();
session_destroy();

// Nettoyer tous les cookies liés à la session
$cookieOptions = [
    'expires' => time() - 3600,
    'path' => '/',
    'domain' => '.tyzi.fr',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
];

// Supprimer tous les cookies de session
setcookie('session_user', '', $cookieOptions);
setcookie('session_date', '', $cookieOptions);
setcookie(session_name(), '', $cookieOptions);

// CORRECTION: URL de redirection complète
header("Location: https://tyzi.fr/geodex/app/?page=login");
exit;
?>