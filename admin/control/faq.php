<?php 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit;
}

$racine_path = '../';
?>

<?php include $racine_path . 'templates/head.php'; ?>
<?php include $racine_path . 'templates/sidebar.php'; ?>
<?php include $racine_path . 'templates/faq.php'; ?>

