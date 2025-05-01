<?php 
// Démarrer une session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DÉBOGAGE: Afficher où on est redirigé
error_log("Geodex.php - START - " . $_SERVER['REQUEST_URI']);

if (!isset($_SESSION['email'])) {
    error_log("Redirection vers login - Pas de session email");
    header("Location: ./");
    exit;
}

// IMPORTANT: Commentez temporairement cette ligne pour tester
// require_once __DIR__ . '/../models/auth_check.php';
require_once __DIR__ . '/../../config/Pierre.php';

$racine_path = './';

// DÉBOGAGE: Point de contrôle
error_log("Geodex.php - AVANT TEMPLATES - Session OK");

if (isset($_GET['id'])) {
    // Code pour afficher une pierre spécifique
    $id = urldecode($_GET['id']);
    $_GET['id'] = $id;
    $racine_path = '../';
    include '../templates/description.php';
} else {
    // Code pour afficher le geodex complet
    include '../templates/head.php';
    include '../templates/sidebar.php';
    include '../templates/geodex.php';
}

// DÉBOGAGE: Fin du script
error_log("Geodex.php - FIN - Succès");
?>
