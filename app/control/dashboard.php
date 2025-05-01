<?php
// Configuration session sécurisée
session_name('TYZISESSID');
session_set_cookie_params([
    'lifetime' => 86400 * 30, // 30 jours
    'path' => '/',
    'domain' => '.tyzi.fr', // Important pour les sous-domaines
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug des cookies/session
error_log("=== DASHBOARD ===");
error_log("Session ID: " . session_id());
error_log("Cookies: " . print_r($_COOKIE, true));

// Gestion multi-auth (session + cookie)
$current_user = $_SESSION['email'] ?? $_COOKIE['session_user'] ?? null;

if (!$current_user) {
    error_log("Redirection vers login");
    header("Location: https://tyzi.fr/geodex/app/?page=login");
    exit;
}

// Synchronisation cookie -> session
if (!isset($_SESSION['email']) && isset($_COOKIE['session_user'])) {
    $_SESSION['email'] = $_COOKIE['session_user'];
    error_log("Session mise à jour depuis cookie");
}

require_once __DIR__ . '/../../config/Pierre.php';

// Templates
include '../templates/head.php';
include '../templates/sidebar.php';
include '../templates/game.php';

error_log("=== FIN DASHBOARD ===");
?>