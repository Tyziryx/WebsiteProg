<?php
// Configuration ABSOLUE du chemin racine
$racine_path = __DIR__ . '/';

// Configuration des cookies de session
session_set_cookie_params([
    'lifetime' => 86400 * 30,
    'path' => '/geodex/app',
    'domain' => 'tyzi.fr',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupération sécurisée de la page
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) ?? 'login';

// Pages protégées
$protected_pages = ['geodex', 'dashboard', 'profil'];

// Redirection si accès non autorisé
if (in_array($page, $protected_pages) && empty($_SESSION['email'])) {
    header("Location: https://tyzi.fr/geodex/app/?page=login");
    exit;
}

// Inclusion des templates
include $racine_path . 'templates/head.php';

if ($page !== 'login') {
    include $racine_path . 'templates/sidebar.php';
}

// Mapping des routes EXISTANTES
$routes = [
    'login'    => 'control/login.php',
    'geodex'   => 'control/geodex.php', 
    'dashboard' => 'control/dashboard.php',
    'profil'   => 'control/profil.php' // Garde le nom original
];

// Gestion de l'inclusion
$controller_path = $racine_path . ($routes[$page] ?? '');

if ($controller_path && file_exists($controller_path)) {
    include $controller_path;
} else {
    include $racine_path . 'templates/404.php';
}