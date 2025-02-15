<?php
// Vérifier si un paramètre 'page' est présent dans l'URL
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    // Définition des chemins autorisés
    $routes = [
        'home' => 'home/index.html',
        'login' => 'app/templates/login.html',
        'contact' => 'home/controllers/contact.html',
    ];

    // Vérifier si la page demandée existe
    if (array_key_exists($page, $routes) && file_exists($routes[$page])) {
        include $routes[$page]; // Inclut directement le fichier sans rediriger
    } else {
        include 'home/index.html'; // Page d'accueil par défaut
    }
} else {
    include 'home/index.html'; // Redirection vers l'accueil si aucun paramètre
}
?>
