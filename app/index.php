<?php
$racine_path = './';
?>

<?php
// session_start();

$page = $_GET['page'] ?? 'login';

// Liste des pages accessibles uniquement aux utilisateurs connectés
$protected_pages = ['geodex', 'dashboard'];

// Vérifie si l'utilisateur tente d'accéder à une page protégée sans être connecté
if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
    header("Location: /public_html/app/control/login.php");
    exit;
}

include 'templates/head.php';

$routes = [
    'login' => 'templates/login.php',
    'geodex' => 'templates/geodex.php',
    'dashboard' => 'templates/dashboard.php',
];

if ($page != 'login') {
    include 'templates/header.php';
    include 'templates/sidebar.php';
}

if (array_key_exists($page, $routes) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    include 'templates/404.php';
}
?>
