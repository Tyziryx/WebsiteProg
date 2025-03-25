<?php
// La session est déjà démarrée dans index.php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: templates/login.php");
    exit;
}

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../class/Users.php';

// Créer une instance de la classe User
$userModel = new \classe\User();

// Récupérer les informations de l'utilisateur par son email
$user = $userModel->getUserByEmail($_SESSION['email']);

if (!$user) {
    header("Location: templates/login.php");
    exit;
}

// Récupérer les messages d'erreur ou de succès
$errors = isset($_SESSION['profile_errors']) ? $_SESSION['profile_errors'] : [];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

// Nettoyer les variables de session
unset($_SESSION['profile_errors']);
unset($_SESSION['success_message']);

// Inclure le template
include __DIR__ . '/../templates/profil.php';
?>