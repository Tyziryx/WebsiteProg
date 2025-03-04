
<main>
        <section class="forms-section">

            <div class="forms">
                <div class="form-wrapper is-active">
                    <button type="button" class="switcher switcher-login">
                        Login
                        <span class="underline"></span>
                    </button>
                    <form class="form form-login" action="/public_html/app/models/process_login.php" method="POST">
                        <fieldset>
                            <legend>Please, enter your email and password for login.</legend>
                            <div class="input-block">
                                <label for="login-email">E-mail</label>
                                <input id="login-email" type="email" name="email" <?php /*required */ ?>>
                            </div>
                            <div class="input-block">
                                <label for="login-password">Password</label>
                                <input id="login-password" type="password" name="password" <?php /*required */ ?>>
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
                    <form class="form form-signup">
                        <fieldset>
                            <legend>Please, enter your email, password and password confirmation for sign up.</legend>
                            <div class="input-block">
                                <label for="signup-email">E-mail</label>
                                <input id="signup-email" type="email" required>
                            </div>
                            <div class="input-block">
                                <label for="signup-password">Password</label>
                                <input id="signup-password" type="password" required>
                            </div>
                            <div class="input-block">
                                <label for="signup-password-confirm">Confirm password</label>
                                <input id="signup-password-confirm" type="password" required>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn-signup">Continue</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script src="/public_html/app/templates/js/login.js"></script>
</body>

</html>