<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/notifications.php';


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


// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifie que l'email et le mot de passe sont fournis
    if (empty($email) || empty($password)) {
        setNotification('error', 'Veuillez remplir tous les champs.');
        header("Location: ../");
        exit;
    }

    /**
     * Requête SQL pour récupérer les informations de l'utilisateur en fonction de l'email fourni.
     * La requête recherche l'email dans la base de données et récupère le mot de passe stocké.
     */    
    $stmt = $pdo->prepare("SELECT email, password FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Vérifier le mot de passe en utilisant password_verify au lieu de comparaison directe
    if ($user && password_verify($password, $user['password'])) {
        /**
         * Si l'utilisateur est authentifié, on démarre une session et on stocke l'email dans la session.
         * L'utilisateur est ensuite redirigé vers la page du tableau de bord.
         */
        // Session classique
        $_SESSION['email'] = $user['email'];

        // Cookie valable 30 jours
        setcookie('session_user', $user['email'], time() + (86400 * 30), "/");
        setcookie('session_date', date('Y-m-d H:i:s'), time() + (86400 * 30), "/");

        // Redirection vers dashboard
        header("Location: ../dashboard");
        exit;
    } else {
        // Message d'erreur de connexion
        setNotification('error', 'Email ou mot de passe incorrect.');
        header("Location: ../");
        exit;
    }
}

// Si ce n'est pas une requête POST, rediriger vers la page de login
setNotification('error', 'Accès non autorisé.');
header("Location: ../");
exit;
?>