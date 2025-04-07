<?php

/**
 * Script de mise à jour des informations d'une pierre.
 * 
 * Ce script permet de supprimer une pierre existante et d'ajouter une nouvelle pierre avec des informations mises à jour, 
 * telles que son nom, sa description et sa rareté. Il s'exécute lorsque le formulaire est soumis en méthode POST.
 * 
 * @package Gestion des pierres
 */


// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/Pierre.php';

use bd\Pierre;
echo "<h3> ok tout va bien </h3>";
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $nom_pierre = $_POST['nom'];
    $description = $_POST['description'];
    $rarete = isset($_POST['rarete']) ? $_POST['rarete'] : 'commune';
    
    // Créer une instance de la classe Pierre pour manipuler les données
    $pierre = new Pierre();

    // Supprimer la pierre existante
    $supprime = $pierre->supprimerPierre($nom_pierre);

    if ($supprime) {
        // Ajouter une nouvelle pierre avec les informations mises à jour
        $ajoute = $pierre->ajouterPierreAvecRarete($nom_pierre, $description, $rarete);

        if ($ajoute) {
            // Rediriger vers une page de confirmation ou vers la liste des pierres
            header("Location: ../manage_home");  
            exit;
        } else {
            echo "Une erreur est survenue lors de l'ajout de la pierre.";
        }
    } else {
        echo "Une erreur est survenue lors de la suppression de la pierre.";
    }
}
else echo "problème post";
?>

