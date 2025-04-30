<?php
// Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si le cookie existe mais que la session n'est pas définie, récupérer les données du cookie
if (isset($_COOKIE['session_user']) && !isset($_SESSION['email'])) {
    $_SESSION['email'] = $_COOKIE['session_user'];
}

// Vérifier les cookies et la session après avoir essayé de restaurer la session
if (!isset($_COOKIE['session_user']) || !isset($_COOKIE['session_date']) || !isset($_SESSION['email'])) {
    // Supprimer les cookies qui pourraient être invalides
    setcookie('session_user', '', time() - 3600, '/');
    setcookie('session_date', '', time() - 3600, '/');
    
    // Redirection en utilisant un chemin relatif plus fiable
    header('Location: ../index.php?page=login');
    exit();
}

// Vérifier si les cookies sont expirés
$sessionDate = strtotime($_COOKIE['session_date']);
$currentDate = time();
$thirtyDaysInSeconds = 30 * 24 * 60 * 60;

if ($currentDate - $sessionDate > $thirtyDaysInSeconds) {
    setcookie('session_user', '', time() - 3600, '/');
    setcookie('session_date', '', time() - 3600, '/');
    header('Location: ../index.php?page=login');
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
