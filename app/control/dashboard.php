<?php 
// Démarrer une session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit;
}

require_once __DIR__ . '/../models/auth_check.php';

$racine_path = './';
?>

<?php include '../templates/head.php'; ?>
<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/game.php'; ?>

