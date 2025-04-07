<?php

/**
 * Script pour supprimer une pierre.
 * 
 * Ce script permet de supprimer une pierre spécifiée par son nom. 
 * Si un nom de pierre est passé dans l'URL, la pierre correspondante est supprimée 
 * en appelant la méthode `supprimerPierre` de la classe `Pierre`. 
 * En cas de succès, un message de confirmation est affiché, et l'utilisateur est redirigé 
 * vers la page principale après 2 secondes. Si une erreur se produit, un message d'erreur est affiché.
 * 
 * @package Gestion des pierres
 */


// Inclure la classe Pierre
require_once __DIR__ . '/../../config/Pierre.php';
require_once __DIR__ . '/../../config/notifications.php';

session_start();

// Vérifier si un nom de pierre est spécifié
if (isset($_GET['nom_pierre']) && !empty($_GET['nom_pierre'])) {
    $nom_pierre = htmlspecialchars($_GET['nom_pierre']);
    
    // Créer une instance de la classe Pierre
    $pierre = new \bd\Pierre();
    
    // Supprimer la pierre
    $result = $pierre->supprimerPierre($nom_pierre);

    // Vérifier si la suppression a réussi
    if ($result) {
        setNotification('success', 'La pierre \'' . $nom_pierre . '\' a été supprimée avec succès.');
    } else {
        setNotification('error', 'Une erreur est survenue lors de la suppression de la pierre \'' . $nom_pierre . '\'.');
    }
    header('Location: ../manage_geodex');
    exit;
} else {
    setNotification('error', 'Aucun nom de pierre n\'a été spécifié pour la suppression.');
    header('Location: ../manage_geodex');
    exit;
}
?>
