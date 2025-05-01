<?php
// Vérifier si la session n'est pas déjà démarrée avant de la démarrer
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupérer la page de destination après login (par défaut: dashboard)
$destination = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard';

// Si l'utilisateur a déjà les cookies de session valides
if (isset($_COOKIE['session_user']) && isset($_COOKIE['session_date'])) {
    $sessionDate = strtotime($_COOKIE['session_date']);
    $currentDate = time();
    $thirtyDaysInSeconds = 30 * 24 * 60 * 60;

    if ($currentDate - $sessionDate <= $thirtyDaysInSeconds) {
        // Rafraîchir la date du cookie
        setcookie('session_date', date('Y-m-d H:i:s'), time() + $thirtyDaysInSeconds, "/");
        
        // Restaurer la session si nécessaire
        if (!isset($_SESSION['email'])) {
            $_SESSION['email'] = $_COOKIE['session_user'];
        }

        // Redirection vers la page demandée ou dashboard par défaut
        header('Location: ./' . $destination);
        exit();
    }
}
?>

<?php
require_once __DIR__ . '/../../config/notifications.php';
$racine_path = './';

// Afficher les notifications si existantes
displayNotification();

// Afficher les erreurs d'inscription si existantes
if (isset($_SESSION['signup_errors']) && !empty($_SESSION['signup_errors'])) {
    echo '<div class="error-container">';
    foreach ($_SESSION['signup_errors'] as $error) {
        echo '<p class="notification error" id="error-msg-'.md5($error).'">' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';
    
    // Script pour faire disparaître les messages d'erreur
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorMsgs = document.querySelectorAll('.error-container .notification');
        errorMsgs.forEach(function(msg) {
            setTimeout(function() {
                msg.classList.add('fade-out');
                setTimeout(function() {
                    msg.style.display = 'none';
                    msg.remove();
                }, 500);
            }, 5000);
        });
    });
    </script>";
    
    unset($_SESSION['signup_errors']);
}
?>

<main>
    <section class="forms-section">
        <div class="forms">
            <div class="form-wrapper is-active">
                <button type="button" class="switcher switcher-login">
                    Login
                    <span class="underline"></span>
                </button>
                
                <form class="form form-login" action="<?php echo $racine_path . 'models/process_login.php'; ?>" method="POST">
                    <fieldset>
                        <legend>Veuillez saisir votre email et mot de passe pour vous connecter.</legend>
                        <div class="input-block">
                            <label for="login-email">E-mail</label>
                            <input id="login-email" type="email" name="email" placeholder="Votre email" required>
                        </div>
                        <div class="input-block">
                            <label for="login-password">Mot de passe</label>
                            <input id="login-password" type="password" name="password" placeholder="Votre mot de passe" required>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn-login">Connexion</button>
                </form>
            </div>
            <div class="form-wrapper">
                <button type="button" class="switcher switcher-signup">
                    Sign Up
                    <span class="underline"></span>
                </button>
                <form class="form form-signup" action="<?php echo $racine_path . 'models/process_signup.php'; ?>" method="POST">
                    <fieldset>
                        <legend>Please, enter your email, password and password confirmation for sign up.</legend>
                        <div class="input-block">
                            <label for="signup-pseudo">Pseudo</label>
                            <input id="signup-pseudo" type="pseudo" name="pseudo" required>
                        </div>
                        <div class="input-block">
                            <label for="signup-email">E-mail</label>
                            <input id="signup-email" type="email" name="email" required>
                        </div>
                        <div class="input-block">
                            <label for="signup-password">Password</label>
                            <input id="signup-password" type="password" name="password" required>
                        </div>
                        <div class="input-block">
                            <label for="signup-password-confirm">Confirm password</label>
                            <input id="signup-password-confirm" type="password" name="confirm_password" required>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn-signup">Continue</button>
                </form>
            </div>
        </div>
    </section>
</main>

<!-- Ajouter le script pour faire disparaître la notification après 5 secondes -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notification = document.getElementById('notification');
    if (notification) {
        setTimeout(function() {
            notification.classList.add('fade-out');
            setTimeout(function() {
                notification.style.display = 'none';
            }, 500);
        }, 5000); // Disparaît après 5 secondes
    }
});
</script>

<script src="templates/js/login.js"></script>
</body>
</html>