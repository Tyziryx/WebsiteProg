<?php
// Inclure la classe Pierre et la gestion de la base de données
require_once __DIR__ . '/../../config/Pierre.php';

header('Content-Type: application/json');

// Vérifier si la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

// Vérifier si les champs nécessaires sont envoyés
if (empty($_POST['nom']) || empty($_POST['description'])) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
    exit;
}

$nom = htmlspecialchars(trim($_POST['nom']));
$description = htmlspecialchars(trim($_POST['description']));
$rarete = isset($_POST['rarete']) ? htmlspecialchars(trim($_POST['rarete'])) : 'commune';

try {
    $pierre = new \bd\Pierre();

    // Vérifier si la pierre existe déjà
    if ($pierre->getPierreByNom($nom)) {
        echo json_encode(['success' => false, 'message' => 'Cette pierre existe déjà.']);
        exit;
    }

    // Ajouter la pierre via la méthode de la classe
    if ($pierre->ajouterPierreAvecRarete($nom, $description, $rarete)) {
        header('Location: ../control/manage_geodex.php?status=success&message=Pierre ajoutée avec succès !');
        exit;
    } else {
        header('Location: ../control/manage_geodex.php?status=error&message=Erreur lors de l\'ajout de la pierre.');
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
