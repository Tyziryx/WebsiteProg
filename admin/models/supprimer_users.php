<?php

/**
 * Script pour supprimer un utilisateur.
 * 
 * Ce script permet de supprimer un utilisateur spécifié par son pseudo.
 * 
 * Il vérifie si un pseudo a été fourni, puis tente de supprimer l'utilisateur
 * en utilisant la méthode `supprimerUtilisateur` de la classe `User`. 
 * Si la suppression est réussie, l'utilisateur est redirigé vers la page de gestion des utilisateurs 
 * avec un message de succès. En cas d'erreur, un message d'erreur est renvoyé.
 * 
 * @package Gestion des utilisateurs
 */


// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';
require_once __DIR__ . '/../../config/notifications.php';

session_start();

// Vérifier si un pseudo est spécifié
if (!isset($_GET['pseudo']) || empty($_GET['pseudo'])) {
    setNotification('error', 'Aucun utilisateur spécifié pour la suppression.');
    header('Location: ../manage_users');
    exit;
}

$pseudo = $_GET['pseudo'];

// Créer une instance de la classe User
$userModel = new \bd\User();

// Supprimer l'utilisateur
try {
    $result = $userModel->supprimerUtilisateur($pseudo);
    
    // Vérifier si la suppression a réussi
    if ($result) {
        setNotification('success', 'L\'utilisateur \'' . $pseudo . '\' a été supprimé avec succès.');
        header('Location: ../manage_users');
        exit;
    } else {
        setNotification('error', 'Une erreur est survenue lors de la suppression de l\'utilisateur \'' . $pseudo . '\'.');
        header('Location: ../manage_users');
        exit;
    }
} catch (Exception $e) {
    setNotification('error', 'Erreur : ' . $e->getMessage());
    header('Location: ../manage_users');
    exit;
}
?>