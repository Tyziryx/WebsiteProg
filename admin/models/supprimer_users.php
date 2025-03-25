<?php
// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';

// Vérifier si un pseudo est spécifié
if (!isset($_GET['pseudo']) || empty($_GET['pseudo'])) {
    header('Location: ../control/manage_users.php?status=error&message=Aucun utilisateur spécifié pour la suppression.');
    exit;
}

$pseudo = $_GET['pseudo'];

// Créer une instance de la classe User
$userModel = new \bd\User();

// Supprimer l'utilisateur
try {
    $result = $userModel->supprimerUtilisateur($pseudo);
    
    // Vérifier si la suppression a réussi
    if ($result) {
        header('Location: ../control/manage_users.php?status=success&message=L\'utilisateur \'' . urlencode($pseudo) . '\' a été supprimé avec succès.');
        exit;
    } else {
        header('Location: ../control/manage_users.php?status=error&message=Une erreur est survenue lors de la suppression de l\'utilisateur \'' . urlencode($pseudo) . '\'.');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../control/manage_users.php?status=error&message=Erreur : ' . urlencode($e->getMessage()));
    exit;
}
?>