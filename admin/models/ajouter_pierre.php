<?php

/**
 * Script pour ajouter une pierre avec une rareté spécifique à la base de données.
 * Ce script gère la réception des données via une requête POST, valide les champs, et tente d'ajouter une nouvelle pierre dans la base de données.
 * Si l'ajout réussit, l'utilisateur est redirigé vers la page de gestion des pierres. En cas d'erreur, un message JSON est renvoyé.
 *
 * @package Gestion des pierres
 */


// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../../config/Pierre.php';
require_once __DIR__ . '/../../config/notifications.php';

session_start();

header('Content-Type: application/json');

// Vérifier si la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

// Vérifier si tous les champs sont remplis
if (empty($_POST['nom']) || empty($_POST['description'])) {
    setNotification('error', 'Veuillez remplir tous les champs.');
    header('Location: ../manage_geodex');
    exit;
}

$nom = htmlspecialchars(trim($_POST['nom']));
$description = htmlspecialchars(trim($_POST['description']));
$rarete = isset($_POST['rarete']) ? htmlspecialchars(trim($_POST['rarete'])) : 'commune';

try {
    $pierre = new \bd\Pierre();

    // Vérifier si la pierre existe déjà
    if ($pierre->getPierreByNom($nom)) {
        setNotification('error', 'Cette pierre existe déjà.');
        header('Location: ../manage_geodex');
        exit;
    }

    // Ajouter la pierre via la méthode de la classe
    if ($pierre->ajouterPierreAvecRarete($nom, $description, $rarete)) {
        setNotification('success', 'Pierre ajoutée avec succès !');
    } else {
        setNotification('error', 'Une erreur est survenue lors de l\'ajout de la pierre.');
    }
    header('Location: ../manage_geodex');
    exit;
} catch (Exception $e) {
    setNotification('error', 'Erreur : ' . $e->getMessage());
    header('Location: ../manage_geodex');
    exit;
}
?>
