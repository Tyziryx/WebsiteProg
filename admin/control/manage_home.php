<?php 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit;
}

$racine_path = '../';

if (isset($_GET['id'])) {
    include $racine_path . 'templates/description.php';
} else {
    include $racine_path . 'templates/head.php';
    include $racine_path . 'templates/sidebar.php';
    include $racine_path . 'templates/home.php';
}
?>
