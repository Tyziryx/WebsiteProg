<?php
// Inclure la configuration et la connexion à la base de données
require_once __DIR__ . '/../../config/config.php';


// Initialiser le tableau d'erreurs
$errors = [];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et nettoyer les données du formulaire
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation des données

    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }

    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }
    echo $password;
    echo $confirm_password;

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Si aucune erreur, procéder à l'inscription
    if (empty($errors)) {
        try {
            // Vérifier si l'utilisateur existe déjà
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
            $stmt->execute(['email' => $email]);
            
            if ($stmt->rowCount() > 0) {
                $errors[] = "Cet email est déjà utilisé.";
            } else {
                // Hasher le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insérer le nouvel utilisateur
                $stmt = $pdo->prepare("INSERT INTO utilisateurs ( email, password) VALUES (:email, :password)");
                $result = $stmt->execute([
                    'email' => $email,
                    'password' => $hashed_password
                ]);
                
                if ($result) {
                    /* 
                    // Code pour la gestion des sessions (à activer plus tard)
                    session_start();
                    $_SESSION['user_id'] = $pdo->lastInsertId();
                    $_SESSION['user_email'] = $email;
                    */
                    
                    // Rediriger vers la page de connexion avec un message de succès
                    header("Location: " . $racine_path . "app/views/profile.php?complete=1");
                    exit;
                } else {
                    $errors[] = "Erreur lors de l'inscription. Veuillez réessayer.";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur de base de données: " . $e->getMessage();
        }
    }
}
?>

<!-- Affichage des erreurs si présentes -->
<?php if (!empty($errors)): ?>
    <div class="error-container">
        <?php foreach ($errors as $error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>