<?php include 'templates/head.php'; ?>
<?php include 'templates/header.php'; ?>

<?php
$page = $_GET['page'] ?? 'home';

$routes = [
    'home' => 'templates/home.php',
    'contact' => 'templates/contact.php',
    'faq' => 'templates/faq.php',
];

if (array_key_exists($page, $routes) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    include 'templates/404.php';
}
?>

<?php include 'templates/footer.php'; ?>
