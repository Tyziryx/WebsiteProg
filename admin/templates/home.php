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
    <button class="add">Ajouter une pierre</button>
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
