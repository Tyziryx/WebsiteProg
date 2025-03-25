<?php
// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';

// Vérifier si la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../control/manage_users.php?status=error&message=Méthode non autorisée.');
    exit;
}

// Vérifier si tous les champs sont remplis
if (empty($_POST['pseudo']) || empty($_POST['email']) || empty($_POST['password'])) {
    header('Location: ../control/manage_users.php?status=error&message=Veuillez remplir tous les champs.');
    exit;
}

// Récupérer et nettoyer les données
$pseudo = htmlspecialchars(trim($_POST['pseudo']));
$email = htmlspecialchars(trim($_POST['email']));
$password = $_POST['password']; // Le mot de passe sera haché
$admin = isset($_POST['admin']) ? (int)$_POST['admin'] : 0;

// Valider l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../control/manage_users.php?status=error&message=Format d\'email invalide.');
    exit;
}

try {
    $userModel = new \bd\User();
    
    // Vérifier si le pseudo existe déjà
    if ($userModel->getUserByPseudo($pseudo)) {
        header('Location: ../control/manage_users.php?status=error&message=Ce pseudo existe déjà.');
        exit;
    }
    
    // Vérifier si l'email existe déjà
    if ($userModel->getUserByEmail($email)) {
        header('Location: ../control/manage_users.php?status=error&message=Cet email est déjà utilisé.');
        exit;
    }
    
    // Hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Ajouter l'utilisateur
    if ($userModel->ajouterUtilisateur($pseudo, $email, $hashed_password, $admin)) {
        // Redirection en cas de succès avec notification
        header('Location: ../control/manage_users.php?status=success&message=Utilisateur ajouté avec succès !');
        exit;
    } else {
        header('Location: ../control/manage_users.php?status=error&message=Erreur lors de l\'ajout.');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../control/manage_users.php?status=error&message=Erreur : ' . urlencode($e->getMessage()));
    exit;
}
?>