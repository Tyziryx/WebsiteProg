<?php
// Rediriger vers index.php?page=home si aucun paramètre 'page' n'est fourni
if (!isset($_GET['page'])) {
    header("Location: index.php?page=home");
    exit;
}

$page = $_GET['page']; // Récupérer la page demandée

// Définition des chemins autorisés
$routes = [
    'home' => 'home/index.php',
    'login' => 'app/templates/login.php',
    'contact' => 'home/templates/contact.php',
    'faq' => 'home/templates/faq.php'
];

// Vérifier si la page demandée est bien dans les routes autorisées
if (array_key_exists($page, $routes)) {
    $file = $routes[$page];

    // Vérifier que le fichier existe et l'inclure
    if (file_exists($file)) {
        include $file;
        exit; // Arrêter l'exécution après inclusion
    }
}

// Si la page demandée n'existe pas, renvoyer une erreur 404
http_response_code(404);
include 'home/templates/404.php';
exit;
