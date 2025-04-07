<?php
session_start();

// Si l'utilisateur a déjà les cookies de session valides, on le redirige vers le dashboard
if (isset($_COOKIE['session_user']) && isset($_COOKIE['session_date'])) {
    echo ('cookie ok');
    $sessionDate = strtotime($_COOKIE['session_date']);
    $currentDate = time();
    $thirtyDaysInSeconds = 30 * 24 * 60 * 60;

    if ($currentDate - $sessionDate <= $thirtyDaysInSeconds) {
        // Optionnel : rafraîchir la date du cookie
        setcookie('session_date', date('Y-m-d H:i:s'), time() + $thirtyDaysInSeconds, "/");

        // Redirection vers le dashboard
        header('Location: ./dashboard');
        exit();
    }
}
?>

<?php include '../templates/head.php'; ?>
<?php include './templates/login.php'; ?>
