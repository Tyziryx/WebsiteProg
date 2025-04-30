<?php
// Démarrer la session avec des paramètres explicites
ini_set('session.cookie_path', '/');
ini_set('session.use_cookies', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CORRECTIF SPÉCIAL IONOS: Restauration forcée de session depuis cookies
if (isset($_COOKIE['session_user']) && !isset($_SESSION['email'])) {
    $_SESSION['email'] = $_COOKIE['session_user'];
    
    // Force-sauvegarder la session
    session_write_close();
    session_start();
    
    // Double vérification - si toujours pas défini, utiliser une solution alternative
    if (!isset($_SESSION['email'])) {
        // Définir une variable globale si la session échoue
        define('USER_EMAIL', $_COOKIE['session_user']);
    }
}

// Utiliser la variable de session ou la constante de secours
$current_user = isset($_SESSION['email']) ? $_SESSION['email'] : (defined('USER_EMAIL') ? USER_EMAIL : null);

// Vérification simplifiée
if (!$current_user) {
    // Si la page courante n'est pas déjà la page de login
    if (!isset($_GET['page']) || $_GET['page'] !== 'login') {
        // Supprimer les cookies
        setcookie('session_user', '', time() - 3600, '/');
        setcookie('session_date', '', time() - 3600, '/');
        
        // Redirection vers login avec une redirection explicite (chemin absolu)
        $base_path = dirname($_SERVER['PHP_SELF']);
        if (substr($base_path, -1) !== '/') {
            $base_path .= '/';
        }
        header("Location: {$base_path}index.php?page=login&reason=no_session");
        exit;
    }
}

// Rafraîchir les cookies avec paramètres explicites
if ($current_user) {
    $expire = time() + (86400 * 30); // 30 jours
    setcookie('session_user', $current_user, $expire, '/');
    setcookie('session_date', date('Y-m-d H:i:s'), $expire, '/'); 
}
?>
