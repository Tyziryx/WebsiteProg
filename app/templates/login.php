

<?php
/*
// Ajoutez ce code au début pour voir la structure des chemins
echo "<h3>Debugging paths:</h3>";
echo "Current file: " . __FILE__ . "<br>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
*/
$racine_path = './'
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
                            <legend>Please, enter your email and password for login.</legend>
                            <div class="input-block">
                                <label for="login-email">E-mail</label>
                                <input id="login-email" type="email" name="email" required>
                            </div>
                            <div class="input-block">
                                <label for="login-password">Password</label>
                                <input id="login-password" type="password" name="mot_de_passe" required>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn-login">Login</button>
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
                                <label for="signup-email">E-mail</label>
                                <input id="signup-email" type="email" name="email" required>
                            </div>
                            <div class="input-block">
                                <label for="signup-password">Password</label>
                                <input id="signup-password" type="password" name="password" required>
                            </div>
                            <div class="input-block">
                                <label for="signup-password-confirm">Confirm password</label>
                                <input id="signup-password-confirm" type="password" name="password_confirm" required>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn-signup">Continue</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script src="<?php echo $racine_path . 'templates/js/login.js'; ?>"></script>
</body>

</html>