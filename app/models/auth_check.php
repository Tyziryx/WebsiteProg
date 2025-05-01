<?php
// auth_check.php - Version sécurisée et optimisée

// Configuration session renforcée
session_name('TYZISESSID');
session_set_cookie_params([
    'lifetime' => 86400 * 30, // 30 jours
    'path' => '/',
    'domain' => '.tyzi.fr', // Domaine principal et sous-domaines
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug des accès
error_log("=== AUTH CHECK ===");
error_log("IP: " . $_SERVER['REMOTE_ADDR']);
error_log("User Agent: " . $_SERVER['HTTP_USER_AGENT']);

// Gestion multi-sources d'authentification
$current_user = $_SESSION['email'] ?? $_COOKIE['session_user'] ?? null;

// Mécanisme de secours Ionos
if (!$current_user && isset($_COOKIE['session_user'])) {
    $_SESSION['email'] = $_COOKIE['session_user'];
    session_write_close();
    session_start();
    $current_user = $_SESSION['email'];
    error_log("Restauration de session depuis cookie Ionos");
}

// Validation finale
if (!$current_user) {
    // Nettoyage complet
    session_unset();
    session_destroy();
    setcookie('session_user', '', time() - 3600, '/', '.tyzi.fr');
    setcookie('session_date', '', time() - 3600, '/', '.tyzi.fr');

    // Redirection sécurisée
    $request_uri = urlencode($_SERVER['REQUEST_URI']);
    header("Location: https://tyzi.fr/geodex/app/?page=login&redirect=$request_uri&code=auth_failed");
    exit;
}

// Rafraîchissement des cookies
$expire = time() + 2592000; // 30 jours
setcookie('session_user', $current_user, $expire, '/', '.tyzi.fr', true, true);
setcookie('session_date', date('c'), $expire, '/', '.tyzi.fr', true, false);

error_log("Authentification réussie pour : $current_user");
?>