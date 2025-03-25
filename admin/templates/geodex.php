<?php
// Inclure la classe Pierre
require_once __DIR__ . '/../../config/Pierre.php';

$pierreModel = new \bd\Pierre();

// Récupérer toutes les pierres disponibles dans la base de données
$allStones = $pierreModel->getAllPierres();

// Vérifier s'il y a des pierres
if (empty($allStones)) {
    echo '<div class="error-message">Aucune pierre disponible.</div>';
    exit;
}

?>

<div class="container">
    <h2>Liste des Pierres</h2>
<!-- Bouton pour ouvrir le modal -->
    <button class="add"  id="openModal">Ajouter une pierre</button>
    <!-- Modal d'ajout -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Ajouter une pierre</h2>
            
            <!-- Formulaire d'ajout -->
            <form id="addStoneForm" method="post" action="../models/ajouter_pierre.php">
                <label for="nom">Nom de la pierre :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="description">Description :</label>
                <textarea id="description" name="description" required></textarea>
                <label for="rarete">Rareté :</label>
                <select id="rarete" name="rarete">
                    <option value="commune">Commune</option>
                    <option value="rare">Rare</option>
                    <option value="epique">Épique</option>
                    <option value="legendaire">Légendaire</option>
                </select>

                <button type="submit" class="btn-submit">Ajouter</button>
            </form>
        </div>
    </div>
    <!-- Modal de modification -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Modifier une pierre</h2>
            
            <!-- Formulaire de modification -->
            <form id="editStoneForm" method="post" action="../models/modifier_pierre.php">
                <input type="hidden" id="editNom" name="nom_pierre">
                
                <label for="editNomInput">Nom de la pierre :</label>
                <input type="text" id="editNomInput" name="nom" required readonly>

                <label for="editDescriptionInput">Description :</label>
                <textarea id="editDescriptionInput" name="description" required></textarea>
                
                <label for="rarete">Rareté :</label>
                <select id="editRarete" name="rarete">
                    <option value="commune">Commune</option>
                    <option value="rare">Rare</option>
                    <option value="epique">Épique</option>
                    <option value="legendaire">Légendaire</option>
                </select>

                <button type="submit" class="btn-submit">Modifier</button>
            </form>
        </div>
    </div>
    <p id="message" style="display:none; color: green;">Pierre ajoutée avec succès !</p>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allStones as $stone): ?>
                <tr>
                    <td><?php echo htmlspecialchars($stone->nom_pierre); ?></td>
                    <td><?php echo htmlspecialchars($stone->description); ?></td>
                    <td>
                        <button class="edit" id="editBtn-<?php echo urlencode($stone->nom_pierre); ?>" 
                            data-nom="<?php echo htmlspecialchars($stone->nom_pierre); ?>" 
                            data-description="<?php echo htmlspecialchars($stone->description); ?>">
                            Modifier
                        </button>
                        <button class="delete" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette pierre?')) window.location.href='../models/supprimer_pierre.php?nom_pierre=<?php echo urlencode($stone->nom_pierre); ?>'">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
