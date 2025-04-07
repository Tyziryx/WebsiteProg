<?php 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit;
}

require_once __DIR__ . '/../../config/Pierre.php';

$racine_path = './';

if (isset($_GET['id'])) {
    // Décoder l'URL pour récupérer le nom original de la pierre
    $id = urldecode($_GET['id']);
    $_GET['id'] = $id; // Mettre à jour la variable GET pour description.php
    
    $racine_path = '../';
    include '../templates/description.php';
} else {
    include '../templates/head.php';
    include '../templates/sidebar.php';
    include '../templates/geodex.php';
}
?>
