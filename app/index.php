<?php include 'templates/head.php'; ?>
<?php include 'templates/header.php'; ?>

<?php

// Récupérer la page, ou définir 'home' par défaut si la page n'est pas spécifiée
$page = $_GET['page'] ?? 'login';

// Définition des routes
$routes = [
    'login' => 'templates/login.php',
    'geodex' => 'templates/geodex.php',
    'dashboard' => 'templates/dashboard.php',

];

// Vérifier si la page demandée est dans les routes définies et que le fichier existe
if (array_key_exists($page, $routes) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    include 'templates/404.php'; // Page 404 si la page n'est pas trouvée
}
?>

