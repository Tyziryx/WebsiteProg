<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/User.php';

$userModel = new \bd\User();

// Vérifier si un pseudo a été fourni
if (isset($_GET['pseudo'])) {
    $pseudo = $_GET['pseudo'];

    // Récupérer les informations de l'utilisateur
    $user = $userModel->getUserByPseudo($pseudo);
    if ($user) {
        // Inverser le rôle admin
        $userModel->toggleAdmin($pseudo, $user->admin);
        header("Location: user_list.php");  // Rediriger vers la liste des utilisateurs
        exit;
    } else {
        // Gérer le cas où l'utilisateur n'existe pas
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "Pseudo non spécifié.";
}
?>
