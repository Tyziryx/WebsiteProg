<?php
// Récupérer le message de succès passé en paramètre GET
$success_message = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>

<main>
    <section class="confirmation-section">
        <div class="container">
            <h2 class="confirmation-title">Merci pour votre message</h2>
            <p class="confirmation-message">
                <?php
                if (!empty($success_message)) {
                    echo '<span class="success-message">' . $success_message . '</span>';
                }
                ?>
            </p>
            <div class="confirmation-links">
                <a href="contact.php" class="back-link">Retourner au formulaire</a>
                <a href="../../" class="back-link">Retourner à l'accueil</a>
            </div>
        </div>
    </section>
</main>

<script src="/public_html/templates/js/script.js"></script>
</body>
</html>
