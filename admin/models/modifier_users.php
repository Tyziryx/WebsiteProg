<?php

/**
 * Script de modification des informations d'un utilisateur.
 * 
 * Ce script permet de modifier les informations d'un utilisateur, y compris son email, son mot de passe et ses droits d'administrateur.
 * Il vérifie que toutes les données nécessaires sont fournies, valide les informations (comme le format de l'email),
 * puis met à jour les données de l'utilisateur dans la base de données.
 * 
 * Si une erreur survient (mauvais format, email déjà utilisé, utilisateur non trouvé, etc.), l'utilisateur est redirigé
 * vers la page de gestion avec un message d'erreur.
 * Si la modification réussit, l'utilisateur est redirigé avec un message de succès.
 *
 * @package Gestion des utilisateurs
 */

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';
require_once __DIR__ . '/../../config/notifications.php';

session_start();

/**
 * Vérification de la méthode de la requête.
 * 
 * Ce script ne doit être exécuté que pour une requête POST.
 * Si la requête n'est pas en POST, redirige l'utilisateur vers la page de gestion avec un message d'erreur.
 * 
 * @return void
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setNotification('error', 'Méthode non autorisée.');
    header('Location: ../manage_users');
    exit;
}

/**
 * Vérification de la présence des données obligatoires.
 * 
 * Ce script vérifie que les champs 'originalPseudo' et 'email' sont remplis.
 * Si l'un de ces champs est vide, l'utilisateur est redirigé avec un message d'erreur.
 * 
 * @return void
 */
if (empty($_POST['originalPseudo']) || empty($_POST['email'])) {
    setNotification('error', 'Données incomplètes.');
    header('Location: ../manage_users');
    exit;
}

// Récupérer et nettoyer les données
$originalPseudo = htmlspecialchars(trim($_POST['originalPseudo']));
$email = htmlspecialchars(trim($_POST['email']));
$password = !empty($_POST['password']) ? $_POST['password'] : null;
$admin = isset($_POST['admin']) ? (int)$_POST['admin'] : 0;

/**
 * Validation de l'email.
 * 
 * Le format de l'email est validé à l'aide de la fonction filter_var.
 * Si l'email est invalide, l'utilisateur est redirigé avec un message d'erreur.
 * 
 * @return void
 */
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setNotification('error', 'Format d\'email invalide.');
    header('Location: ../manage_users');
    exit;
}

try {
    $userModel = new \bd\User();
    
    // Récupérer l'utilisateur actuel
    $originalUser = $userModel->getUserByPseudo($originalPseudo);
    if (!$originalUser) {
        setNotification('error', 'Utilisateur non trouvé.');
        header('Location: ../manage_users');
        exit;
    }
    
    // Si l'email a changé, vérifier qu'il n'est pas déjà utilisé par un autre utilisateur
    if ($originalUser->email !== $email) {
        $existingUserByEmail = $userModel->getUserByEmail($email);
        if ($existingUserByEmail && $existingUserByEmail->pseudo !== $originalPseudo) {
            setNotification('error', 'Cet email est déjà utilisé.');
            header('Location: ../manage_users');
            exit;
        }
    }
    
    // Préparer les données pour la mise à jour
    $userData = [
        'email' => $email,
        'admin' => $admin
    ];
    
    // Ajouter le mot de passe uniquement s'il a été fourni
    if ($password !== null) {
        $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
    
    // Mettre à jour l'utilisateur
    if ($userModel->modifierUtilisateur($originalPseudo, $userData)) {
        setNotification('success', 'Utilisateur modifié avec succès !');
        header('Location: ../manage_users');
        exit;
    } else {
        setNotification('error', 'Erreur lors de la modification.');
        header('Location: ../manage_users');
        exit;
    }
} catch (Exception $e) {
    setNotification('error', 'Erreur : ' . $e->getMessage());
    header('Location: ../manage_users');
    exit;
}
?>