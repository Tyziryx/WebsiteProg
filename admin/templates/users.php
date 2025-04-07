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
    <!-- Bouton pour ouvrir le modal d'ajout -->
    <button class="add" id="openAddModal">Ajouter un utilisateur</button>
    
    <!-- Modal d'ajout -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddModal">&times;</span>
            <h2>Ajouter un Utilisateur</h2>
            
            <!-- Formulaire d'ajout -->
            <form id="addUserForm" method="post" action="models/ajouter_users.php">
                <label for="pseudo">Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

                <label for="admin">Rôle :</label>
                <select id="admin" name="admin">
                    <option value="0">Utilisateur</option>
                    <option value="1">Administrateur</option>
                </select>

                <button type="submit" class="btn-submit">Ajouter</button>
            </form>
        </div>
    </div>
    
    <!-- Modal de modification -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Modifier l'Utilisateur</h2>
            
            <!-- Formulaire de modification -->
            <form id="editUserForm" method="post" action="models/modifier_users.php">
                <!-- Champ caché pour stocker le pseudo original -->
                <input type="hidden" id="editOriginalPseudo" name="originalPseudo">
                
                <label for="editPseudo">Pseudo :</label>
                <input type="text" id="editPseudo" name="pseudo" readonly>

                <label for="editEmail">Email :</label>
                <input type="email" id="editEmail" name="email" required>

                <label for="editPassword">Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
                <input type="password" id="editPassword" name="password">

                <label for="editAdmin">Rôle :</label>
                <select id="editAdmin" name="admin">
                    <option value="0">Utilisateur</option>
                    <option value="1">Administrateur</option>
                </select>

                <button type="submit" class="btn-submit">Modifier</button>
            </form>
        </div>
    </div>
    
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
                        <button class="edit" id="editBtn-<?php echo urlencode($user->pseudo); ?>" 
                            data-pseudo="<?php echo htmlspecialchars($user->pseudo); ?>" 
                            data-email="<?php echo htmlspecialchars($user->email); ?>"
                            data-admin="<?php echo htmlspecialchars($user->admin); ?>">
                            Modifier
                        </button>

                        <!-- Bouton pour supprimer l'utilisateur -->
                        <button class="delete" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')) window.location.href='models/supprimer_users.php?pseudo=<?php echo urlencode($user->pseudo); ?>'">Supprimer</button>

                        <!-- Bouton pour changer le rôle (admin/non-admin) -->
                        <button class="toggle-admin" onclick="if(confirm('Êtes-vous sûr de vouloir changer le rôle de cet utilisateur?')) window.location.href='models/toggle_admin.php?pseudo=<?php echo urlencode($user->pseudo); ?>'">
                            <?php echo $user->admin ? 'Retirer Admin' : 'Passer Admin'; ?>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// Récupérer les éléments du DOM pour les modales
const addModal = document.getElementById('addModal');
const editModal = document.getElementById('editModal');
const openAddModalBtn = document.getElementById('openAddModal');
const closeAddModalBtn = document.getElementById('closeAddModal');
const closeEditModalBtn = document.getElementById('closeEditModal');

// Ouvrir la modale d'ajout
openAddModalBtn.addEventListener('click', function() {
    addModal.style.display = 'block';
});

// Fermer la modale d'ajout
closeAddModalBtn.addEventListener('click', function() {
    addModal.style.display = 'none';
});

// Fermer la modale de modification
closeEditModalBtn.addEventListener('click', function() {
    editModal.style.display = 'none';
});

// Fermer les modales lorsque l'utilisateur clique en dehors
window.addEventListener('click', function(event) {
    if (event.target === addModal) {
        addModal.style.display = 'none';
    }
    if (event.target === editModal) {
        editModal.style.display = 'none';
    }
});

// Validation du formulaire d'ajout
document.getElementById('addUserForm').addEventListener('submit', function(e) {
    const pseudo = document.getElementById('pseudo').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    
    if (pseudo === '' || email === '' || password === '') {
        alert('Veuillez remplir tous les champs');
        e.preventDefault();
        return;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Veuillez entrer une adresse email valide');
        e.preventDefault();
        return;
    }
});

// Validation du formulaire de modification
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    const email = document.getElementById('editEmail').value.trim();
    
    if (email === '') {
        alert('L\'email ne peut pas être vide');
        e.preventDefault();
        return;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Veuillez entrer une adresse email valide');
        e.preventDefault();
        return;
    }
});

// Gérer les boutons de modification
document.querySelectorAll('[id^="editBtn-"]').forEach(button => {
    button.addEventListener('click', function() {
        // Récupérer les données de l'utilisateur
        const pseudo = this.getAttribute('data-pseudo');
        const email = this.getAttribute('data-email');
        const admin = this.getAttribute('data-admin');
        
        // Remplir le formulaire de modification
        document.getElementById('editOriginalPseudo').value = pseudo;
        document.getElementById('editPseudo').value = pseudo;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPassword').value = '';
        
        // Sélectionner la bonne option pour le rôle
        const adminSelect = document.getElementById('editAdmin');
        for (let i = 0; i < adminSelect.options.length; i++) {
            if (adminSelect.options[i].value === admin) {
                adminSelect.selectedIndex = i;
                break;
            }
        }
        
        // Afficher la modale
        editModal.style.display = 'block';
    });
});
</script>
