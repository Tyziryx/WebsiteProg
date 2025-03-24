<main>
    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="contact-title">Contactez-nous</h2>
            <p class="contact-subtitle">Une question ? Remplissez ce formulaire et nous vous répondrons rapidement.</p>

            <!-- Affichage des messages d'erreur ou de succès -->
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="success-message"><?php echo htmlspecialchars($_GET['success']); ?></div>
            <?php endif; ?>

            <form action="../models/process_contact.php" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" placeholder="Votre nom" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Votre email" required>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Votre message" rows="5" required></textarea>
                </div>

                <button type="submit" class="contact-button">Envoyer</button>
            </form>
        </div>
    </section>
</main>

<script src="../templates/js/script.js"></script>
</body>
</html>
