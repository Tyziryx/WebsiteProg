<?php
// Configuration STRICTE des cookies de session
session_set_cookie_params([
    'lifetime' => 86400 * 30, // 30 jours
    'path' => '/geodex/app',  // Chemin ABSOLU
    'domain' => 'tyzi.fr',    // Domaine explicite
    'secure' => true,         // HTTPS uniquement
    'httponly' => true,       // Anti-vol de cookie
    'samesite' => 'Lax'       // Protection CSRF
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/notifications.php';

// Connexion DB avec gestion d'erreur
try {
    $db = new \bd\GestionBD();
    $pdo = $db->connexion();
} catch (PDOException $e) {
    error_log("DB error: " . $e->getMessage());
    die("Erreur technique - Code 500");
}

// Traitement uniquement des requêtes POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Validation basique
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
        setNotification('error', 'Formulaire invalide');
        header("Location: https://tyzi.fr/geodex/app/?page=login");
        exit;
    }

    try {
        // Requête préparée avec gestion d'erreur
        $stmt = $pdo->prepare("SELECT email, password FROM utilisateurs WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        
        if (!$stmt->execute()) {
            throw new PDOException("Erreur d'exécution de requête");
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Régénération ID de session
            session_regenerate_id(true);
            
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; // Fixation de session

            // Cookies personnalisés
            $cookieParams = [
                'expires' => time() + 86400 * 30,
                'path' => '/geodex/app',
                'domain' => 'tyzi.fr',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ];

            setcookie('session_user', $user['email'], $cookieParams);
            setcookie('session_auth', bin2hex(random_bytes(16)), $cookieParams);

            header("Location: https://tyzi.fr/geodex/app/dashboard");
            exit;

        } else {
            setNotification('error', 'Identifiants incorrects');
            header("Location: https://tyzi.fr/geodex/app/?page=login");
            exit;
        }

    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        setNotification('error', 'Erreur système');
        header("Location: https://tyzi.fr/geodex/app/?page=login");
        exit;
    }
}

// Blocage des accès directs
setNotification('error', 'Méthode non autorisée');
header("Location: https://tyzi.fr/geodex/app/?page=login");
exit;
?>