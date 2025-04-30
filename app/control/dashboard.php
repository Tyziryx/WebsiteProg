<?php 
// Début du fichier
session_start();

// Solution de secours pour Ionos
$current_user = isset($_SESSION['email']) ? $_SESSION['email'] : 
                (isset($_COOKIE['session_user']) ? $_COOKIE['session_user'] : null);

// Utiliser la variable $current_user au lieu de $_SESSION['email']
if (!$current_user) {
    header("Location: ./index.php?page=login");
    exit;
}

// Pour le reste du script, définir $_SESSION['email'] si nécessaire
if (!isset($_SESSION['email']) && $current_user) {
    $_SESSION['email'] = $current_user;
}

// Continuer avec le code existant...
require_once __DIR__ . '/../models/auth_check.php';

$racine_path = './';
?>

<?php include '../templates/head.php'; ?>
<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/game.php'; ?>

