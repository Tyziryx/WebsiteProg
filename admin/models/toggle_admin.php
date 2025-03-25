<?php
// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';

// Vérifier si un pseudo est spécifié
if (!isset($_GET['pseudo']) || empty($_GET['pseudo'])) {
    header('Location: ../control/manage_users.php?status=error&message=Aucun utilisateur spécifié.');
    exit;
}

$pseudo = $_GET['pseudo'];

// Créer une instance de la classe User
$userModel = new \bd\User();

try {
    // Récupérer l'utilisateur actuel
    $user = $userModel->getUserByPseudo($pseudo);
    
    if (!$user) {
        header('Location: ../control/manage_users.php?status=error&message=Utilisateur non trouvé.');
        exit;
    }
    
    // Inverser le statut admin
    $result = $userModel->toggleAdminSwitch($pseudo);
    
    if ($result) {
        // Récupérer le nouveau statut pour afficher un message adéquat
        $newStatus = $userModel->isAdminStatus($pseudo);
        $statusText = $newStatus ? "administrateur" : "utilisateur standard";
        
        header('Location: ../control/manage_users.php?status=success&message=Le statut de l\'utilisateur \'' . urlencode($pseudo) . '\' a été changé en ' . $statusText . ' avec succès.');
        exit;
    } else {
        header('Location: ../control/manage_users.php?status=error&message=Une erreur est survenue lors du changement de statut.');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../control/manage_users.php?status=error&message=Erreur : ' . urlencode($e->getMessage()));
    exit;
}
?>
