<?php 
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit;
}

$racine_path = '../';

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/Users.php';

// Créer une instance de la classe User
$userModel = new \bd\User();

// Récupérer les informations de l'utilisateur par son email
$user = $userModel->getUserByEmail($_SESSION['email']);

if (!$user) {
    header("Location: ../index.php?page=login");
    exit;
}

// Récupérer les messages d'erreur ou de succès
$errors = isset($_SESSION['profile_errors']) ? $_SESSION['profile_errors'] : [];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

// Nettoyer les variables de session
unset($_SESSION['profile_errors']);
unset($_SESSION['success_message']);

// Inclure les templates pour l'affichage
include $racine_path . 'templates/head.php';
include $racine_path . 'templates/sidebar.php';
include $racine_path . 'templates/profil.php';
?>
