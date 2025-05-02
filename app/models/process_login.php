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
        // DEBUGGING: Ajouter des logs détaillés
        error_log("===== TENTATIVE DE CONNEXION =====");
        error_log("Email: " . $email);
        
        $stmt = $pdo->prepare("
            SELECT email, password  
            FROM utilisateurs 
            WHERE email = :email
        ");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            error_log("Erreur SQL: " . print_r($errorInfo, true));
            throw new PDOException("Erreur d'exécution: " . $errorInfo[2]);
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Débogage pour voir si l'utilisateur est trouvé
        error_log("Utilisateur trouvé: " . ($user ? "OUI" : "NON"));
        if ($user) {
            error_log("Hash stocké: " . substr($user['password'], 0, 15) . "...");
        }

        if ($user && password_verify($password, $user['password'])) {
            error_log("Vérification du mot de passe: RÉUSSIE");
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
            if ($user) {
                error_log("Vérification du mot de passe: ÉCHEC");
                // DEBUGGING: Test temporaire du hash pour geodex@geo.fr
                if ($email === 'geodex@geo.fr') {
                    $manualCheck = password_verify($password, '$2y$10$Cn7kV6O29wQe7gcCAtYg1eFPBCKGeSNfsYoVNPvWdcqAK7xR5N/Gm');
                    error_log("Test manuel du hash: " . ($manualCheck ? "RÉUSSI" : "ÉCHEC"));
                }
            }
            setNotification('error', 'Email ou mot de passe incorrect');
            header("Location: https://tyzi.fr/geodex/app/?page=login");
            exit;
        }

    } catch (PDOException $e) {
        // Amélioration des logs d'erreur
        error_log("===== ERREUR PDO DÉTAILLÉE =====");
        error_log("Message: " . $e->getMessage());
        error_log("Code: " . $e->getCode());
        error_log("Trace: " . $e->getTraceAsString());
        
        setNotification('error', 'Erreur de base de données');
        header("Location: https://tyzi.fr/geodex/app/?page=login");
        exit;
    }
}

setNotification('error', 'Accès non autorisé');
header("Location: https://tyzi.fr/geodex/app/?page=login");
exit;
?>