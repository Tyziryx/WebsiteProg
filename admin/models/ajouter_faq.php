<?php
require_once __DIR__ . '/../../config/Pierre.php';

header('Content-Type: application/json');

// Vérifier si la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

// Vérifier que les champs nécessaires sont présents
if (empty($_POST['question']) || empty($_POST['reponse'])) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
    exit;
}

// Nettoyer les entrées pour éviter les attaques XSS
$question = htmlspecialchars(trim(urldecode($_POST['question'])));
$question = html_entity_decode($question);
$reponse = htmlspecialchars(trim(urldecode($_POST['reponse'])));
$reponse = html_entity_decode($reponse);
$admin = false;

echo ($question);

try {
    $faq = new \bd\Pierre();

    // Ajouter la FAQ à la base de données
    if ($faq->ajouterFaq($question, $reponse, $admin)) {
        header("Location: ../control/manage_faq.php?success=1");
    } else {
        header("Location: ../control/manage_faq.php?error=1");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
?>
