<?php
// Inclure la classe Pierre
require_once __DIR__ . '/../../config/Pierre.php';

if (isset($_GET['nom_pierre']) && !empty($_GET['nom_pierre'])) {
    $nom_pierre = $_GET['nom_pierre'];

    // Créer une instance de la classe Pierre
    $pierre = new \bd\Pierre();

    // Supprimer la pierre
    $result = $pierre->supprimerPierre($nom_pierre);

    // Vérifier si la suppression a réussi
    if ($result) {
        echo "La pierre '$nom_pierre' a été supprimée avec succès.";
        // Rediriger après 2 secondes vers la page principale
        header("refresh:2;url=../control/manage_home.php");
    } else {
        echo "Une erreur est survenue lors de la suppression de la pierre '$nom_pierre'.";
    }
} else {
    echo "Aucun nom de pierre n'a été spécifié pour la suppression.";
}
?>
