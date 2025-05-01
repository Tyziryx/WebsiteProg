<?php 
// Démarrer une session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DÉBOGAGE avec information explicite
error_log("GEODEX.PHP - Démarrage - URI: " . $_SERVER['REQUEST_URI']);

// Vérifier la session directement au lieu d'utiliser auth_check.php
if (!isset($_SESSION['email'])) {
    // Si pas de session mais cookie présent, restaurer la session
    if (isset($_COOKIE['session_user'])) {
        $_SESSION['email'] = $_COOKIE['session_user'];
        error_log("Session restaurée depuis cookie: " . $_COOKIE['session_user']);
    } else {
        error_log("Redirection vers login - Pas de session email");
        header("Location: ./?page=login&redirect=geodex");
        exit;
    }
}

require_once __DIR__ . '/../../config/Pierre.php';
$racine_path = './';

// Point de contrôle après session
error_log("GEODEX.PHP - Session OK: " . $_SESSION['email']);

if (isset($_GET['id'])) {
    // Code pour afficher une pierre spécifique
    $id = urldecode($_GET['id']);
    $_GET['id'] = $id;
    $racine_path = '../';
    include '../templates/description.php';
} else {
    // IMPORTANT: Vérifier si les templates sont chargés
    error_log("GEODEX.PHP - Chargement des templates");
    include '../templates/head.php';
    include '../templates/sidebar.php';
    include '../templates/geodex.php';
}

// Log de fin d'exécution
error_log("GEODEX.PHP - Fin d'exécution avec succès");
?>
