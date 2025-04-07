<?php
// Inclure la configuration et la connexion à la base de données
include __DIR__ . '/../../config/GestionBD.php';

// Créer la connexion à la base de données

$db = new \bd\GestionBD();
$pdo = $db->connexion();


// Initialiser le tableau d'erreurs
$errors = [];

/**
 * Traitement du formulaire d'inscription de l'utilisateur.
 * Ce script vérifie les données soumises via un formulaire et enregistre un nouvel utilisateur dans la base de données si les données sont valides.
 * Les étapes incluent la validation des données du formulaire, la vérification de l'existence de l'utilisateur, le hachage du mot de passe et l'insertion des données dans la base de données.
 * 
 * @throws PDOException Si une erreur de base de données se produit pendant la requête.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer et nettoyer les données du formulaire
    $pseudo= $_POST['pseudo'] ?? '';
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation des données


    echo "<h2>Données reçues:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    /**
     * Validation des données de l'utilisateur : pseudo, email, mot de passe.
     * Les erreurs sont stockées dans le tableau $errors.
     */
    if (empty($pseudo)) {
        $errors[] = "Le pseudo est obligatoire.";
    } elseif (!preg_match('/^[a-zA-Z]/', $pseudo)) {
        $errors[] = "Le pseudo doit commencer par une lettre.";
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $pseudo)) {
        $errors[] = "Le pseudo ne doit contenir que des lettres et des chiffres.";
    }


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
            } 

            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
            $stmt->execute(['pseudo' => $pseudo]);
            
            if ($stmt->rowCount() > 0) {
                $errors[] = "Ce pseudo est déjà utilisé.";
            } 

            
            else {
                // Hasher le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insérer le nouvel utilisateur
                $stmt = $pdo->prepare("INSERT INTO utilisateurs ( pseudo , email, password) VALUES (:pseudo , :email, :password)");
                $result = $stmt->execute([
                    'pseudo' => $pseudo,
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
                    header("Location: " . $racine_path . "../index.php");
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