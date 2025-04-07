<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit;
}

$racine_path = '../';

require_once __DIR__ . '/../../config/notifications.php';

include $racine_path . 'templates/head.php';
include $racine_path . 'templates/sidebar.php';

// Afficher la notification si elle existe
displayNotification();

// Inclure le template pour la FAQ
require_once __DIR__ . '/../templates/faq_users.php';
?>
