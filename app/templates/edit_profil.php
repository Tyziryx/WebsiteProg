<main>
    <section class="profile-section">
        <h1>Mon Profil</h1>
        <form action="/AMS/app/models/process_profil.php" method="POST" class="profile-form">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" placeholder="Votre nom" value="John Doe">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Votre email" value="johndoe@example.com">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Nouveau mot de passe">
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirmer le mot de passe</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmer le mot de passe">
            </div>
            <button type="submit" class="btn-submit">Mettre à jour</button>
        </form>
    </section>
</main>
