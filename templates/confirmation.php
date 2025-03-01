
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
            <a href="/AMS/control/contact.php" class="back-link">Retourner au formulaire</a>
        </div>
    </section>
</main>

<script src="../templates/js/script.js"></script>
</body>
</html>
