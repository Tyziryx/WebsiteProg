<?php
$racine_path = './';
// Start the session at the beginning if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'login';

// Liste des pages accessibles uniquement aux utilisateurs connectés
$protected_pages = ['geodex', 'dashboard', 'profil'];

// Vérifie si l'utilisateur tente d'accéder à une page protégée sans être connecté
if (in_array($page, $protected_pages) && !isset($_SESSION['email'])) {
    header("Location: index.php?page=login");
    exit;
}

include 'templates/head.php';

$routes = [
    'login' => 'templates/login.php',
    'geodex' => 'control/geodex.php',
    'dashboard' => 'control/dashboard.php',
    'profil' => 'control/profil_controller.php',
];

if ($page !== 'login') {
    include 'templates/sidebar.php';
}

if (array_key_exists($page, $routes) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    include 'templates/404.php';
}
?>
