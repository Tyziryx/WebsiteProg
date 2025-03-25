<main>
    <section class="profile-section">
        <h1>Mon Profil</h1>
        
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo $racine_path; ?>models/process_profil.php" method="POST" class="profile-form">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" id="pseudo" name="pseudo" value="<?php echo isset($user->pseudo) ? htmlspecialchars($user->pseudo) : ''; ?>" readonly>
                <small>Le pseudo ne peut pas être modifié</small>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo isset($user->email) ? htmlspecialchars($user->email) : ''; ?>">
            </div>
            <div class="form-group password-group">
                <label for="password">Mot de passe</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Nouveau mot de passe">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <small>Laissez vide pour conserver le mot de passe actuel</small>
            </div>
            <div class="form-group password-group">
                <label for="confirm-password">Mot de passe (confirmation)</label>
                <div class="password-container">
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirmer le mot de passe">
                    <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password')">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn-submit">Mettre à jour</button>
        </form>
    </section>
</main>

<!-- Script pour afficher/masquer le mot de passe -->
<script>
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const icon = event.currentTarget.querySelector('i');
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>