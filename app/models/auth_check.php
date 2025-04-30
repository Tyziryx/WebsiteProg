<?php
// Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// TEMPORAIRE: Bypass d'authentification pour diagnostic
if (isset($_GET['bypass'])) {
    $_SESSION['email'] = 'bypass@example.com';
    echo "Session définie via bypass. <a href='dashboard'>Continuer</a>";
    exit;
}

// Si les cookies sont présents mais la session absente
if (isset($_COOKIE['session_user']) && !isset($_SESSION['email'])) {
    $_SESSION['email'] = $_COOKIE['session_user'];
}

// Vérification simplifiée: on vérifie uniquement si la session existe
if (!isset($_SESSION['email'])) {
    // Session inexistante - rediriger vers login avec un paramètre clair
    header("Location: index.php?page=login&reason=no_session");
    exit;
}

// Si on arrive ici, l'authentification est réussie
// On peut simplement rafraîchir les cookies si nécessaire
if (isset($_COOKIE['session_user'])) {
    $path = "/";
    setcookie('session_date', date('Y-m-d H:i:s'), time() + (86400 * 30), $path);
}
?>
