<?php
require_once __DIR__ . '/../config/notifications.php';
?>

<main>
    <section class="confirmation-section">
        <div class="container">
            <h2 class="confirmation-title">Merci pour votre message</h2>
            <p class="confirmation-message">
                <?php 
                $notification = getNotification();
                if ($notification && $notification['status'] === 'success') {
                    echo '<span class="success-message">' . htmlspecialchars($notification['message']) . '</span>';
                } else {
                    echo "Votre message a été envoyé avec succès. Nous vous contacterons bientôt.";
                }
                ?>
            </p>
            <div class="confirmation-links">
                <a href="contact" class="back-link">Retourner au formulaire</a>
                <a href="./" class="back-link">Retourner à l'accueil</a>
            </div>
        </div>
    </section>
</main>

<script src="/templates/js/script.js"></script>
</body>
</html>
