
<main>
    <section class="confirmation-section">
        <div class="container">
            <h2 class="confirmation-title">Merci pour votre message</h2>
            <p class="confirmation-message">
                <?php
                // Afficher le message de succès ou d'erreur
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                } elseif (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
                ?>
            </p>
            <a href="/public_html/control/contact.php" class="back-link">Retourner au formulaire</a>
            <a href="/public_html/" class="back-link">Retourner à l'accueil</a>
        </div>
    </section>
</main>

<script src="/public_html/templates/js/script.js"></script>
</body>
</html>
