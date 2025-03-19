<?php

session_start();
include __DIR__ . '/../../config/GestionBD.php';

// Créer la connexion à la base de données

$db = new \bd\GestionBD();
$pdo = $db->connexion();
/*

try {
    $dsn = "pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
} 
*/ 



// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';


    //Debugging
    /*
    echo "<h2>Données reçues:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
*/

    // Vérifie que l'email et le mot de passe sont fournis
    if (empty($email) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }

    // Requête pour récupérer l'utilisateur
    $stmt = $pdo->prepare("SELECT email, password , admin FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

   //   Debugging 
/*
    echo "<h3>Données de l'utilisateur trouvées:</h3>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
 */
    // Vérifier le mot de passe en utilisant password_verify au lieu de comparaison directe
    if ($user && password_verify($password, $user['password'])) {
        // Utiliser l'email comme identifiant de session au lieu de l'ID
        if ($user['admin'] == TRUE) {
            // Utiliser l'email comme identifiant de session
            $_SESSION['email'] = $user['email'];
            $_SESSION['admin'] = TRUE;
            
            $racine_path = '../';
            header("Location: " . $racine_path . "control/manage_home.php");
            exit;
        } else {
            // L'utilisateur est authentifié mais n'est pas admin
            echo "Vous n'avez pas les droits d'administrateur.";
        }
    } else {
        // Message d'erreur de connexion
        echo "Email ou mot de passe incorrect.";
    }   
/*
        echo "Mot de passe saisi: " . $password
 . "<br>";
        echo "Mot de passe attendu: " . ($user ? $user['password
'] : "Utilisateur non trouvé");
        */
    }
        

?>