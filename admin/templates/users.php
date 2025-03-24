<?php

require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Users.php';


$userModel = new \bd\User();  // Assurez-vous que c'est bien \bd\User et non \bd\Users

// Récupérer tous les utilisateurs disponibles dans la base de données
try {
    $allUsers = $userModel->getAllUsers();
} catch (Exception $e) {
    die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
}

// Vérifier s'il y a des utilisateurs
if (empty($allUsers)) {
    echo '<div class="error-message">Aucun utilisateur disponible.</div>';
    exit;
}
?>

<div class="container">
    <h2>Liste des Utilisateurs</h2>
    <button class="add" onclick="window.location.href='add_user.php'">Ajouter un utilisateur</button>
    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allUsers as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user->pseudo); ?></td>
                    <td><?php echo htmlspecialchars($user->email); ?></td>
                    <td>
                        <?php echo $user->admin ? 'Admin' : 'Utilisateur'; ?>
                    </td>
                    <td>
                        <!-- Bouton pour modifier l'utilisateur -->
                        <button class="edit" onclick="window.location.href='edit_user.php?pseudo=<?php echo urlencode($user->pseudo); ?>'">Modifier</button>

                        <!-- Bouton pour supprimer l'utilisateur -->
                        <button class="delete" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')) window.location.href='delete_user.php?pseudo=<?php echo urlencode($user->pseudo); ?>'">Supprimer</button>

                        <!-- Bouton pour changer le rôle (admin/non-admin) -->
                        <button class="toggle-admin" onclick="if(confirm('Êtes-vous sûr de vouloir changer le rôle de cet utilisateur?')) window.location.href='toggle_admin.php?pseudo=<?php echo urlencode($user->pseudo); ?>'">
                            <?php echo $user->admin ? 'Retirer Admin' : 'Passer Admin'; ?>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
