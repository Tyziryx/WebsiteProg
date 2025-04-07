<?php

/**
 * Script de gestion de la connexion utilisateur avec vérification des droits d'administrateur.
 * 
 * Ce script permet à un utilisateur de se connecter en vérifiant son email et son mot de passe.
 * Si l'utilisateur est authentifié et possède les droits d'administrateur, une session est créée
 * et il est redirigé vers la page de gestion de l'administration.
 * Si l'utilisateur n'a pas les droits d'administrateur, un message d'erreur est affiché.
 * En cas de mot de passe incorrect, un message d'erreur est aussi affiché.
 * 
 * @package Authentification et gestion des utilisateurs
 */

session_start();
include __DIR__ . '/../../config/GestionBD.php';

// Créer la connexion à la base de données

$db = new \bd\GestionBD();
$pdo = $db->connexion();

/**
 * Traitement du formulaire de connexion lorsque la méthode de la requête est POST.
 * 
 * - Récupère l'email et le mot de passe fournis par l'utilisateur via le formulaire.
 * - Vérifie que les champs ne sont pas vides.
 * - Effectue une requête préparée pour récupérer l'utilisateur correspondant à l'email donné.
 * - Si l'utilisateur est trouvé et que le mot de passe est correct, il est authentifié.
 * - Si l'utilisateur est un administrateur, une session est créée et l'utilisateur est redirigé vers la page de gestion.
 * - Si l'utilisateur n'est pas un administrateur, un message d'erreur est affiché.
 * - Si l'authentification échoue, un message d'erreur est affiché.
 *
 * @return void
 */

 
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
            header("Location: ../manage_home");
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