<?php

if (session_status() === PHP_SESSION_NONE) {
    // Configuration spécifique du cookie de session
    session_set_cookie_params([
        'lifetime' => 86400 * 30,
        'path' => '/geodex/app', // Chemin absolu de l'application
        'domain' => 'tyzi.fr',
        'secure' => true, // FORCÉ en HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

include __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/notifications.php';

$db = new \bd\GestionBD();
$pdo = $db->connexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        setNotification('error', 'Veuillez remplir tous les champs.');
        header("Location: https://tyzi.fr/geodex/app/login");
        exit;
    }

    // Requête améliorée avec gestion des erreurs
    try {
        $stmt = $pdo->prepare("SELECT email, password FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];

            // Cookies avec paramètres cohérents
            $cookieOptions = [
                'expires' => time() + 86400 * 30,
                'path' => '/geodex/app', // Chemin ABSOLU
                'domain' => 'tyzi.fr',
                'secure' => true, // HTTPS obligatoire
                'httponly' => true,
                'samesite' => 'Lax'
            ];

            setcookie('session_user', $user['email'], $cookieOptions);
            setcookie('session_date', date('Y-m-d H:i:s'), $cookieOptions);

            header("Location: https://tyzi.fr/geodex/app/dashboard");
            exit;
        } else {
            setNotification('error', 'Identifiants incorrects');
            header("Location: https://tyzi.fr/geodex/app/login");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erreur de connexion : " . $e->getMessage());
        setNotification('error', 'Erreur technique');
        header("Location: https://tyzi.fr/geodex/app/login");
        exit;
    }
}

setNotification('error', 'Accès invalide');
header("Location: https://tyzi.fr/geodex/app/login");
exit;
?>