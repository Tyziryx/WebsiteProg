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
require_once __DIR__ . '/../../config/notifications.php';

session_start();

// Vérifier si la requête est en GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    setNotification('error', 'Méthode non autorisée.');
    header('Location: ../manage_faq');
    exit;
}

// Vérifier que le champ nécessaire est présent
if (empty($_GET['question'])) {
    setNotification('error', 'Veuillez fournir une question à supprimer.');
    header('Location: ../manage_faq');
    exit;
}

// Nettoyer l'entrée pour éviter les attaques XSS
$question = htmlspecialchars(trim(urldecode($_GET['question'])));
// Décoder les entités HTML (comme &quot;, &amp;, etc.)
$question = html_entity_decode($question);

// Restaurer les ' en remplaçant les ! par '
$question = str_replace("!", "'", $question);

try {
    $faq = new \bd\Pierre();

    // Supprimer la FAQ de la base de données
    if ($faq->supprimerFaq($question)) {
        // Redirection vers la page FAQ avec un message de succès
        setNotification('success', 'FAQ supprimée avec succès !');
    } else {
        // Redirection avec un message d'erreur si la suppression a échoué
        setNotification('error', 'Une erreur est survenue lors de la suppression de la FAQ.');
    }
    header('Location: ../manage_faq');
    exit;
} catch (Exception $e) {
    setNotification('error', 'Erreur : ' . $e->getMessage());
    header('Location: ../manage_faq');
    exit;
}
?>
