<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php?page=login");
    exit;
}

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/Users.php';

// Créer une instance de la classe User
$userModel = new \bd\User();

// Récupérer les informations de l'utilisateur actuel
$currentUser = $userModel->getUserByEmail($_SESSION['email']);

if (!$currentUser) {
    $_SESSION['profile_errors'] = ["Utilisateur non trouvé."];
    header("Location: ../index.php?page=profil");
    exit;
}

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Valider les données
    $errors = [];
    
    // Valider l'email
    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }
    
    // Valider le mot de passe uniquement s'il est fourni
    if (!empty($password)) {
        if (strlen($password) < 6) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
        }
        
        if ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }
    }
    
    // S'il y a des erreurs, rediriger vers la page de profil avec des messages d'erreur
    if (!empty($errors)) {
        $_SESSION['profile_errors'] = $errors;
        header("Location: ../index.php?page=profil");
        exit;
    }
    
    // Mettre à jour les informations de l'utilisateur
    $result = false;
    
    if (!empty($password)) {
        // Mettre à jour l'email et le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $userModel->updateUser($currentUser->pseudo, $email, $hashedPassword);
    } else {
        // Mettre à jour uniquement l'email
        $result = $userModel->updateUserEmail($currentUser->pseudo, $email);
    }
    
    if ($result) {
        // Mettre à jour l'email dans la session
        $_SESSION['email'] = $email;
        $_SESSION['success_message'] = "Votre profil a été mis à jour avec succès.";
        
        // Déconnecter l'utilisateur et le rediriger vers login
        session_unset();
        session_destroy();
        // On recrée une session pour passer le message de succès
        session_start();
        $_SESSION['login_message'] = "Votre profil a été mis à jour. Veuillez vous reconnecter.";
        header("Location: ../index.php?page=login");
        exit;
    } else {
        $_SESSION['profile_errors'] = ["Une erreur s'est produite lors de la mise à jour de votre profil."];
        header("Location: ../index.php?page=profil");
        exit;
    }
}

// Si ce n'est pas une requête POST, rediriger vers la page d'accueil
header("Location: ../index.php");
exit;