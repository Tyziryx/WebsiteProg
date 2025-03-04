<?php
// Démarre la session pour gérer les informations de l'utilisateur
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: /public_html/app/control/login.php");
    exit;
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';

    // Validation basique des données
    $errors = [];

    if (empty($name)) {
        $errors[] = "Le nom est requis.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    }

    if (!empty($password) && $password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Si aucune erreur, traiter les données (par exemple, mettre à jour la base de données)
    if (empty($errors)) {
        // Simulation de l'action de mise à jour (tu pourrais connecter à la BDD ici)
        // Pour l'instant, juste afficher les nouvelles données
        echo "Nom: $name <br>";
        echo "Email: $email <br>";

        if (!empty($password)) {
            // Simuler la mise à jour du mot de passe (en réalité, il faudrait le hasher avant de le stocker)
            echo "Mot de passe modifié. <br>";
        }

        echo "<a href='/public_html/app/control/profil.php'>Retourner au profil</a>";
        exit;
    } else {
        // Afficher les erreurs
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>
