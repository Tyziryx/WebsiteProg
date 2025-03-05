<?php
/* 
session_start();
require '../model/db.php'; // Assure-toi d'avoir un fichier qui gère la connexion à la BDD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifie que l'email et le mot de passe sont fournis
    if (empty($email) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }

    // Requête pour récupérer l'utilisateur
    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: ../index.php?page=dashboard"); // Redirige vers le tableau de bord
        exit;
    } else {
        echo "Identifiants incorrects.";
    }
}
    */
?>

<?php
session_start();


// Désactivation temporaire de l'authentification
$_SESSION['user_id'] = 1; // Simule un utilisateur connecté
$_SESSION['email'] = "test@example.com";
$racine_path = '../';
header("Location: " . $racine_path . "control/manage_home.php");exit;
echo "yo    ";

?>
