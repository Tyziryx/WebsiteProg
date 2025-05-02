<?php
// Configuration STRICTE des cookies de session
session_set_cookie_params([
    'lifetime' => 86400 * 30,
    'path' => '/geodex/app',
    'domain' => 'tyzi.fr',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/notifications.php';

try {
    $db = new \bd\GestionBD();
    $pdo = $db->connexion();
} catch (PDOException $e) {
    error_log("DB error: " . $e->getMessage());
    die(json_encode(['status' => 'error', 'message' => 'Erreur technique']));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
        setNotification('error', 'Formulaire invalide');
        header("Location: https://tyzi.fr/geodex/app/?page=login");
        exit;
    }

    try {
        // Correction du schéma et nom de colonne
        $stmt = $pdo->prepare("
            SELECT email, mot_de_passe 
            FROM uapv2401411.utilisateurs 
            WHERE email = :email
        ");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        
        if (!$stmt->execute()) {
            throw new PDOException("Erreur d'exécution de requête");
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            session_regenerate_id(true);
            
            $_SESSION['email'] = $user['email'];
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

            // Cookies avec vérification de l'écriture
            $cookieParams = [
                'expires' => time() + 86400 * 30,
                'path' => '/geodex/app',
                'domain' => 'tyzi.fr',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ];

            if (!setcookie('session_user', $user['email'], $cookieParams)) {
                error_log("Échec écriture cookie session_user");
            }

            header("Location: https://tyzi.fr/geodex/app/dashboard");
            exit;

        } else {
            setNotification('error', 'Email ou mot de passe incorrect');
            header("Location: https://tyzi.fr/geodex/app/?page=login");
            exit;
        }

    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        setNotification('error', 'Erreur de base de données');
        header("Location: https://tyzi.fr/geodex/app/?page=login");
        exit;
    }
}

setNotification('error', 'Accès non autorisé');
header("Location: https://tyzi.fr/geodex/app/?page=login");
exit;
?>