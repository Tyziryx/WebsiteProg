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
session_start();

// Détruit la session actuelle, déconnectant ainsi l'utilisateur
session_destroy();

/**
 * Redirige l'utilisateur vers la page d'accueil après la déconnexion.
 */
header("Location: ../");
exit;
?>
