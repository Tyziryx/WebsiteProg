<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit;
}

$racine_path = '../';

require_once __DIR__ . '/../../config/notifications.php';

if (isset($_GET['id'])) {
    include $racine_path . 'templates/description.php';
} else {
    include $racine_path . 'templates/head.php';
    include $racine_path . 'templates/sidebar.php';

    // Titre de la page
    echo "<title>Gestion des Utilisateurs</title>";

    // Afficher la notification si elle existe
    displayNotification();

    // Inclure le template pour les utilisateurs
    require_once __DIR__ . '/../templates/users.php';
}
?>
