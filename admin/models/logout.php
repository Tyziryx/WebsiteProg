<?php
/**
 * Déconnexion de l'utilisateur.
 * 
 * Ce script permet de déconnecter l'utilisateur en détruisant la session active et en redirigeant l'utilisateur
 * vers la page d'accueil (index.php).
 * 
 * @package Gestion des utilisateurs
 */

// Démarre la session
session_start();

// Détruire toutes les données de la session
session_destroy();

// Redirige l'utilisateur vers la page d'accueil
header("Location: ../");
exit;
?>
