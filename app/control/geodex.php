<?php 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit;
}

require_once __DIR__ . '/../../config/Pierre.php';

$racine_path = './';

if (isset($_GET['id'])) {
    $racine_path = '../';
    include '../templates/description.php';
} else {
    include '../templates/head.php';
    include '../templates/sidebar.php';
    include '../templates/geodex.php';
}
?>
