<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/notifications.php';

// Créer la connexion à la base de données
$db = new \bd\GestionBD();
$pdo = $db->connexion();

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = trim(htmlspecialchars($_POST['pseudo'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation des données
    $errors = [];

    // Validation du pseudo
    if (empty($pseudo)) {
        $errors[] = "Le pseudo est obligatoire.";
    } elseif (!preg_match('/^[a-zA-Z]/', $pseudo)) {
        $errors[] = "Le pseudo doit commencer par une lettre.";
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $pseudo)) {
        $errors[] = "Le pseudo ne doit contenir que des lettres et des chiffres.";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }

    // Validation du mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    // Vérification de la correspondance des mots de passe
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // S'il y a des erreurs, stocker dans la session et rediriger
    if (!empty($errors)) {
        $_SESSION['signup_errors'] = $errors;
        $_SESSION['form_data'] = [
            'pseudo' => $pseudo,
            'email' => $email
        ];
        header("Location: ../");
        exit;
    }

    try {
        // Vérifier si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $email]);
        
        if ($stmt->rowCount() > 0) {
            setNotification('error', "Cet email est déjà utilisé.");
            $_SESSION['form_data'] = [
                'pseudo' => $pseudo
            ];
            header("Location: ../");
            exit;
        } 

        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
        $stmt->execute(['pseudo' => $pseudo]);
        
        if ($stmt->rowCount() > 0) {
            setNotification('error', "Ce pseudo est déjà utilisé.");
            $_SESSION['form_data'] = [
                'email' => $email
            ];
            header("Location: ../");
            exit;
        } 
        
        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer le nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (pseudo, email, password) VALUES (:pseudo, :email, :password)");
        $result = $stmt->execute([
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $hashed_password
        ]);
        
        if ($result) {
            setNotification('success', "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.");
            header("Location: ../");
            exit;
        } else {
            setNotification('error', "Erreur lors de l'inscription. Veuillez réessayer.");
            $_SESSION['form_data'] = [
                'pseudo' => $pseudo,
                'email' => $email
            ];
            header("Location: ../");
            exit;
        }
    } catch (PDOException $e) {
        setNotification('error', "Erreur de base de données: " . $e->getMessage());
        $_SESSION['form_data'] = [
            'pseudo' => $pseudo,
            'email' => $email
        ];
        header("Location: ../");
        exit;
    }
}

// Si ce n'est pas une requête POST, rediriger vers la page de login
setNotification('error', "Méthode non autorisée.");
header("Location: ../");
exit;
?>
