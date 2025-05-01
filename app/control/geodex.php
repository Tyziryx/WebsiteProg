<?php
// Configuration session
session_name('TYZISESSID');
session_set_cookie_params([
    'lifetime' => 86400 * 30, // 30 jours
    'path' => '/',
    'domain' => 'tyzi.fr',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug
error_log("=== DEBUT GEODEX.PHP ===");
error_log("Cookies : " . print_r($_COOKIE, true));
error_log("Session ID : " . session_id());
error_log("Session data : " . print_r($_SESSION, true));

// Vérification authentification
if (!isset($_SESSION['email'])) {
    if (!empty($_COOKIE['session_user'])) {
        $_SESSION['email'] = $_COOKIE['session_user'];
        error_log("Session restaurée depuis cookie");
    } else {
        error_log("Redirection vers login");
        header("Location: https://tyzi.fr/geodex/app/?page=login&redirect=geodex");
        exit;
    }
}

require_once __DIR__ . '/../../config/Pierre.php';

// Logique de routage
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = urldecode($_GET['id']);
    include '../templates/description.php';
} else {
    include '../templates/head.php';
    include '../templates/sidebar.php';
    include '../templates/geodex.php';
}

error_log("=== FIN GEODEX.PHP ===");
?>