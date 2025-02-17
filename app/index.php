<?php include 'templates/head.php'; ?>
<?php include 'templates/header.php'; ?>

<?php
if (!isset($_GET['page'])) {
    header("Location: index.php");  // Redirige vers home/index.php (relatif au répertoire actuel)
    exit;
}
// Récupérer la page, ou définir 'home' par défaut si la page n'est pas spécifiée
$page = $_GET['page'] ?? 'login';

// Définition des routes
$routes = [
    'home' => 'templates/home.php',
    'login' => 'templates/login.php',
    'geodex' => 'templates/geodex.php',
    'dashboard' => 'templates/dashboard.php',
    'contact' => 'templates/contact.php',
    'faq' => 'templates/faq.php',
];

// Vérifier si la page demandée est dans les routes définies et que le fichier existe
if (array_key_exists($page, $routes) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    include 'templates/404.php'; // Page 404 si la page n'est pas trouvée
}
?>

<?php include 'templates/footer.php'; ?>