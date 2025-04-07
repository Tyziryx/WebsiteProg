<?php

session_start();
include __DIR__ . '/../../config/GestionBD.php';


/**
 * Script de gestion de la connexion utilisateur.
 * 
 * Ce script traite la soumission d'un formulaire de connexion, vérifie si les informations fournies sont valides,
 * et si oui, démarre une session pour l'utilisateur et le redirige vers son tableau de bord. 
 * En cas d'erreur, un message approprié est affiché.
 * 
 * La validation se fait via la vérification du mot de passe haché stocké dans la base de données.
 * 
 * @throws Exception Si une erreur survient lors de la connexion à la base de données.
 */


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

    /**
     * Requête SQL pour récupérer les informations de l'utilisateur en fonction de l'email fourni.
     * La requête recherche l'email dans la base de données et récupère le mot de passe stocké.
     */    
    $stmt = $pdo->prepare("SELECT email, password FROM utilisateurs WHERE email = :email");
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
        /**
         * Si l'utilisateur est authentifié, on démarre une session et on stocke l'email dans la session.
         * L'utilisateur est ensuite redirigé vers la page du tableau de bord.
         */
        $_SESSION['email'] = $user['email'];

        
        $racine_path = '../';
        header("Location: " . $racine_path . "dashboard");
        exit;
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