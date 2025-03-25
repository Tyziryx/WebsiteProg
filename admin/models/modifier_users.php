<?php
// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';

// Vérifier si la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../control/manage_users.php?status=error&message=Méthode non autorisée.');
    exit;
}

// Vérifier si tous les champs obligatoires sont remplis
if (empty($_POST['originalPseudo']) || empty($_POST['email'])) {
    header('Location: ../control/manage_users.php?status=error&message=Données incomplètes.');
    exit;
}

// Récupérer et nettoyer les données
$originalPseudo = htmlspecialchars(trim($_POST['originalPseudo']));
$email = htmlspecialchars(trim($_POST['email']));
$password = !empty($_POST['password']) ? $_POST['password'] : null;
$admin = isset($_POST['admin']) ? (int)$_POST['admin'] : 0;

// Valider l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../control/manage_users.php?status=error&message=Format d\'email invalide.');
    exit;
}

try {
    $userModel = new \bd\User();
    
    // Récupérer l'utilisateur actuel
    $originalUser = $userModel->getUserByPseudo($originalPseudo);
    if (!$originalUser) {
        header('Location: ../control/manage_users.php?status=error&message=Utilisateur non trouvé.');
        exit;
    }
    
    // Si l'email a changé, vérifier qu'il n'est pas déjà utilisé par un autre utilisateur
    if ($originalUser->email !== $email) {
        $existingUserByEmail = $userModel->getUserByEmail($email);
        if ($existingUserByEmail && $existingUserByEmail->pseudo !== $originalPseudo) {
            header('Location: ../control/manage_users.php?status=error&message=Cet email est déjà utilisé.');
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
        header('Location: ../control/manage_users.php?status=success&message=Utilisateur modifié avec succès !');
        exit;
    } else {
        header('Location: ../control/manage_users.php?status=error&message=Erreur lors de la modification.');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../control/manage_users.php?status=error&message=Erreur : ' . urlencode($e->getMessage()));
    exit;
}
?>