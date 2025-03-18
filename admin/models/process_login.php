<?php
// Démarrer la session
session_start();

// Inclure le fichier de configuration
include __DIR__ . '/../../config/config.php';

// Se connecter à la base de données
try {
    $dsn = "pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

// Traiter le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    
    // Vérifier si champs remplis
    if (empty($email) || empty($mot_de_passe)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }
    
    // Chercher l'utilisateur et vérifier s'il est admin
    $stmt = $pdo->prepare("SELECT email, mot_de_passe, admin FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    
    // Vérifier les identifiants et droits admin
    if ($user && $mot_de_passe === $user['mot_de_passe'] && $user['admin'] === true) {
        // Connexion admin réussie
        $_SESSION['admin'] = true;
        $_SESSION['email'] = $user['email'];
        
        // Correction du problème de chemin doublon
        header("Location: ../control/manage_home.php");
        exit;
    } else {
        // Messages d'erreur
        if (!$user) {
            echo "Email non enregistré.";
        } elseif ($mot_de_passe !== $user['mot_de_passe']) {
            echo "Mot de passe incorrect.";
        } else {
            echo "Pas de droits administrateur.";
        }
    }
}

// Option d'accès automatique (commentée)
/*
$_SESSION['admin'] = true;
$_SESSION['email'] = "test@example.com";
header("Location: ../control/manage_home.php");
exit;
*/
?>