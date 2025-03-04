<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./control/login.php");
    exit;
}

$racine_path = './';
?>

<?php include $racine_path . 'app/templates/head.php'; ?>
<?php include $racine_path . 'app/templates/sidebar.php'; ?>
<?php include $racine_path . 'app/templates/game.php'; ?>