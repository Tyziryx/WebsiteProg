<?php

/**
 * Traitement de la création d'un utilisateur.
 * Ce script traite la soumission d'un formulaire pour ajouter un utilisateur en vérifiant les champs et en ajoutant l'utilisateur à la base de données.
 * Il gère également les erreurs et redirige l'utilisateur avec des messages appropriés.
 * 
 * @package Gestion des utilisateurs
 */


// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';
require_once __DIR__ . '/../../config/notifications.php';

session_start();

// Vérifier si la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setNotification('error', 'Méthode non autorisée.');
    header('Location: ../manage_users');
    exit;
}

// Vérifier si tous les champs sont remplis
if (empty($_POST['pseudo']) || empty($_POST['email']) || empty($_POST['password'])) {
    setNotification('error', 'Veuillez remplir tous les champs.');
    header('Location: ../manage_users');
    exit;
}

// Récupérer et nettoyer les données
$pseudo = htmlspecialchars(trim($_POST['pseudo']));
$email = htmlspecialchars(trim($_POST['email']));
$password = $_POST['password']; // Le mot de passe sera haché
$admin = isset($_POST['admin']) ? (int)$_POST['admin'] : 0;

// Valider l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setNotification('error', 'Format d\'email invalide.');
    header('Location: ../manage_users');
    exit;
}

try {
    $userModel = new \bd\User();
    
    // Vérifier si le pseudo existe déjà
    if ($userModel->getUserByPseudo($pseudo)) {
        setNotification('error', 'Ce pseudo existe déjà.');
        header('Location: ../manage_users');
        exit;
    }
    
    // Vérifier si l'email existe déjà
    if ($userModel->getUserByEmail($email)) {
        setNotification('error', 'Cet email est déjà utilisé.');
        header('Location: ../manage_users');
        exit;
    }
    
    // Hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Ajouter l'utilisateur
    if ($userModel->ajouterUtilisateur($pseudo, $email, $hashed_password, $admin)) {
        // Redirection en cas de succès avec notification
        setNotification('success', 'Utilisateur ajouté avec succès !');
        header('Location: ../manage_users');
        exit;
    } else {
        setNotification('error', 'Erreur lors de l\'ajout.');
        header('Location: ../manage_users');
        exit;
    }
} catch (Exception $e) {
    setNotification('error', 'Erreur : ' . $e->getMessage());
    header('Location: ../manage_users');
    exit;
}
?>