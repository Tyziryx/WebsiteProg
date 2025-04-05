<?php 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit;
}

$racine_path = './';
?>

<?php include '../templates/head.php'; ?>
<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/game.php'; ?>

