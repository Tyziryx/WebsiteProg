<?php
// Inclure la classe Pierre
require_once __DIR__ . '/../../config/Pierre.php';

$pierreModel = new \bd\Pierre();

// Récupérer toutes les pierres disponibles dans la base de données
$allStones = $pierreModel->getPierresByRarete("commune");

// Vérifier s'il y a des pierres
if (empty($allStones)) {
    echo '<div class="error-message">Aucune pierre disponible.</div>';
    exit;
}

?>

<div class="container">
    <h2>Liste des Pierres</h2>
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

                <button type="submit" class="btn-submit">Ajouter</button>
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
                        <button class="edit" onclick="window.location.href='edit_pierre.php?id=<?php echo urlencode($stone->nom_pierre); ?>'">Modifier</button>
                        <button class="delete" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette pierre?')) window.location.href='delete_pierre.php?id=<?php echo urlencode($stone->nom_pierre); ?>'">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
