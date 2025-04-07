<?php
// Démarrer une session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_COOKIE['session_user']) || !isset($_COOKIE['session_date'])) {
    header('Location: /login');
    exit();
}

$sessionDate = strtotime($_COOKIE['session_date']);
$currentDate = time();
$thirtyDaysInSeconds = 30 * 24 * 60 * 60;

if ($currentDate - $sessionDate > $thirtyDaysInSeconds) {
    // Cookies expirés : supprimer et rediriger
    setcookie('session_user', '', time() - 3600, '/');
    setcookie('session_date', '', time() - 3600, '/');
    header('Location: ../login');
    exit();
}

// Optionnel : Rafraîchir le cookie
setcookie('session_date', date('Y-m-d H:i:s'), time() + (86400 * 30), "/");
?>
