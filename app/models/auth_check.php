<?php
// Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier les cookies et la session
if (!isset($_COOKIE['session_user']) || !isset($_COOKIE['session_date']) || !isset($_SESSION['email'])) {
    // Supprimer les cookies qui pourraient être invalides
    setcookie('session_user', '', time() - 3600, '/');
    setcookie('session_date', '', time() - 3600, '/');
    
    // Utiliser un chemin absolu pour la redirection
    header('Location: ' . getBaseUrl() . 'app/index.php?page=login');
    exit();
}

// Vérifier si les cookies sont expirés
$sessionDate = strtotime($_COOKIE['session_date']);
$currentDate = time();
$thirtyDaysInSeconds = 30 * 24 * 60 * 60;

if ($currentDate - $sessionDate > $thirtyDaysInSeconds) {
    setcookie('session_user', '', time() - 3600, '/');
    setcookie('session_date', '', time() - 3600, '/');
    header('Location: ' . getBaseUrl() . 'app/index.php?page=login');
    exit();
}

// Rafraîchir le cookie de date
setcookie('session_date', date('Y-m-d H:i:s'), time() + $thirtyDaysInSeconds, "/");

// Fonction pour obtenir l'URL de base
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['SCRIPT_NAME'], 3); // Remonte de 3 niveaux depuis ce fichier
    return $protocol . $host . $path . '/';
}
?>
