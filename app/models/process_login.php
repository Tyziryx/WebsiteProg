<?php

session_start();
include '/../../config/config.php';

// Créer la connexion à la base de données
try {
    $dsn = "pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    /* Debugging 
    echo "<h2>Données reçues:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
*/
    // Vérifie que l'email et le mot de passe sont fournis
    if (empty($email) || empty($mot_de_passe)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }

    // Requête pour récupérer l'utilisateur
    $stmt = $pdo->prepare("SELECT email, mot_de_passe FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    /* Debugging 

    echo "<h3>Données de l'utilisateur trouvées:</h3>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
*/ 


    // Vérifier le mot de passe en texte clair au lieu d'utiliser password_verify
    if ($user && $mot_de_passe === $user['mot_de_passe']) {
        // Utiliser l'email comme identifiant de session au lieu de l'ID
        $_SESSION['email'] = $user['email'];
        
        $racine_path = '../';
        header("Location: " . $racine_path . "control/dashboard.php");
        exit;

    } else {

        echo "Identifiants incorrects.<br>";

    }
}
?>