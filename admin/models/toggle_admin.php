<?php
// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';

/**
 * Script pour inverser le statut d'un utilisateur (admin ou utilisateur standard).
 * 
 * Ce script vérifie si un pseudo est passé via la méthode GET, puis récupère l'utilisateur associé. 
 * Si l'utilisateur existe, il inverse son statut d'administrateur. 
 * Un message de succès ou d'erreur est renvoyé en fonction du résultat.
 * 
 * @throws Exception Si une erreur se produit lors de la récupération ou de la mise à jour du statut de l'utilisateur.
 */

// Vérifier si un pseudo est spécifié
if (!isset($_GET['pseudo']) || empty($_GET['pseudo'])) {
    header('Location: ../manage_users?status=error&message=Aucun utilisateur spécifié.');
    exit;
}

$pseudo = $_GET['pseudo'];

// Créer une instance de la classe User
$userModel = new \bd\User();

try {
    // Récupérer l'utilisateur actuel
    $user = $userModel->getUserByPseudo($pseudo);
    
    if (!$user) {
        header('Location: ../manage_users?status=error&message=Utilisateur non trouvé.');
        exit;
    }
    
    // Inverser le statut admin
    $result = $userModel->toggleAdminSwitch($pseudo);
    
    if ($result) {
        // Récupérer le nouveau statut pour afficher un message adéquat
        $newStatus = $userModel->isAdminStatus($pseudo);
        $statusText = $newStatus ? "administrateur" : "utilisateur standard";
        
        // Correction ici : "../manage_users" au lieu de "../control/manage_users.php"
        header('Location: ../manage_users?status=success&message=Le statut de l\'utilisateur \'' . urlencode($pseudo) . '\' a été changé en ' . $statusText . ' avec succès.');
        exit;
    } else {
        // Correction ici : "../manage_users" au lieu de "../control/manage_users.php"
        header('Location: ../manage_users?status=error&message=Une erreur est survenue lors du changement de statut.');
        exit;
    }
} catch (Exception $e) {
    // Correction ici : "../manage_users" au lieu de "../control/manage_users.php"
    header('Location: ../manage_users?status=error&message=Erreur : ' . urlencode($e->getMessage()));
    exit;
}
?>
