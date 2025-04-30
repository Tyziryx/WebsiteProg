<?php
// Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pour déboguer: afficher un commentaire indiquant où on est
// error_log("Auth check - Session: " . json_encode($_SESSION) . " Cookies: " . json_encode($_COOKIE));

// TEMPORAIRE: Bypass d'authentification pour diagnostic
if (isset($_GET['bypass'])) {
    $_SESSION['email'] = 'bypass@example.com';
    echo "Session définie via bypass. <a href='dashboard'>Continuer</a>";
    exit;
}

// Si les cookies sont présents mais la session absente
if (isset($_COOKIE['session_user']) && !isset($_SESSION['email'])) {
    $_SESSION['email'] = $_COOKIE['session_user'];
    // S'assurer que la session est sauvegardée immédiatement
    session_write_close();
    session_start();
}

// Vérification simplifiée sans redirection en boucle
if (!isset($_SESSION['email'])) {
    // Si la page courante n'est pas déjà la page de login
    if (!isset($_GET['page']) || $_GET['page'] !== 'login') {
        // Supprimer les cookies potentiellement problématiques
        setcookie('session_user', '', time() - 3600, '/');
        setcookie('session_date', '', time() - 3600, '/');
        
        // Rediriger vers la page de login
        header("Location: ./index.php?page=login&reason=no_session");
        exit;
    }
    // Sinon, ne rien faire car on est déjà sur la page de login
}

// Si on arrive ici, l'authentification est réussie
// Rafraîchir les cookies si nécessaire en utilisant la syntaxe compatible
if (isset($_SESSION['email'])) {
    $expire = time() + (86400 * 30); // 30 jours
    $path = "/";
    
    // Utiliser la syntaxe compatible pour tous les PHP
    setcookie('session_user', $_SESSION['email'], $expire, $path);
    setcookie('session_date', date('Y-m-d H:i:s'), $expire, $path);
}
?>
