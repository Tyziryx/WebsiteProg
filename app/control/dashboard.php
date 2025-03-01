<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /AMS/app/control/login.php");
    exit;
}
?>

<?php include '../templates/head.php'; ?>
<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/game.php'; ?>
