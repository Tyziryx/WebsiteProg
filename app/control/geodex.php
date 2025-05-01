<?php 
// Démarrer une session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Débogage pour comprendre le problème de redirection
error_log("Accès à geodex.php - SESSION: " . json_encode($_SESSION) . " - COOKIES: " . json_encode($_COOKIE));

if (!isset($_SESSION['email'])) {
    error_log("Redirection vers login - Pas de session email");
    header("Location: ./");
    exit;
}

// Déplacer require auth_check après la vérification de session
// pour éviter une redirection en cascade
require_once __DIR__ . '/../../config/Pierre.php';
require_once __DIR__ . '/../models/auth_check.php';

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
