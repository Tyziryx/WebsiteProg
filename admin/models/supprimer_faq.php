<?php

/**
 * Script pour supprimer une FAQ.
 * 
 * Ce script permet de supprimer une question de la FAQ en vérifiant que la requête est en méthode GET
 * et que le champ nécessaire (question) est fourni. Il nettoie l'entrée pour éviter les attaques XSS
 * et tente ensuite de supprimer la FAQ en appelant la méthode `supprimerFaq` de la classe `Pierre`.
 * En cas de succès, une redirection vers la page de gestion de la FAQ est effectuée avec un message de succès,
 * sinon un message d'erreur est renvoyé.
 * 
 * @package Gestion des FAQ
 */

// Inclure la classe Pierre
require_once __DIR__ . '/../../config/Pierre.php';

header('Content-Type: application/json');

// Vérifier si la requête est en GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

// Vérifier que le champ nécessaire est présent
if (empty($_GET['question'])) {
    echo json_encode(['success' => false, 'message' => 'Veuillez fournir une question à supprimer.']);
    exit;
}

// Nettoyer l'entrée pour éviter les attaques XSS
$question = htmlspecialchars(trim(urldecode($_GET['question'])));
// Décoder les entités HTML (comme &quot;, &amp;, etc.)
$question = html_entity_decode($question);

// Restaurer les ' en remplaçant les ! par '
$question = str_replace("!", "'", $question);
echo ($question);

try {
    $faq = new \bd\Pierre();

    // Supprimer la FAQ de la base de données
    if ($faq->supprimerFaq($question)) {
        // Redirection vers la page FAQ avec un message de succès
        header("Location: ../manage_faq?success=1");
        exit;
    } else {
        // Redirection avec un message d'erreur si la suppression a échoué
        header("Location: ../manage_faq?error=1");
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
