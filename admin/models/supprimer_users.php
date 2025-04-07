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

// Vérifier si un pseudo est spécifié
if (!isset($_GET['pseudo']) || empty($_GET['pseudo'])) {
    header('Location: ../manage_users?status=error&message=Aucun utilisateur spécifié pour la suppression.');
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
        header('Location: ../manage_users?status=success&message=L\'utilisateur \'' . urlencode($pseudo) . '\' a été supprimé avec succès.');
        exit;
    } else {
        header('Location: ../manage_users?status=error&message=Une erreur est survenue lors de la suppression de l\'utilisateur \'' . urlencode($pseudo) . '\'.');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../manage_users?status=error&message=Erreur : ' . urlencode($e->getMessage()));
    exit;
}
?>