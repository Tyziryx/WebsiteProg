<?php
// Démarrer une session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/Pierre.php';
require_once __DIR__ . '/../../config/GestionBD.php';
require_once __DIR__ . '/../models/auth_check.php';

// Créer une instance de la classe Pierre (AVANT de l'utiliser)
$pierreModel = new \bd\Pierre();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {  // Utiliser 'email' au lieu de 'pseudo'
    echo "Erreur|commune|Utilisateur non connecté|image1.png|0";
    exit;
}

$userEmail = $_SESSION['email'];

// Générer un nombre aléatoire pour déterminer la rareté
$random = mt_rand(1, 100);

// Déterminer la rareté en fonction du nombre aléatoire
if ($random <= 70) {
    $rarete = 'commune';
} elseif ($random <= 90) {
    $rarete = 'rare';
} elseif ($random <= 98) {
    $rarete = 'epique';
} else {
    $rarete = 'legendaire';
}

// Récupérer toutes les pierres de cette rareté
$pierres = $pierreModel->getPierresByRarete($rarete);

// S'il n'y a pas de pierres dans cette rareté, essayer une autre
if (empty($pierres)) {
    $rarete = 'commune';
    $pierres = $pierreModel->getPierresByRarete($rarete);
}

// S'il y a toujours pas de pierres, renvoyer une erreur
if (empty($pierres)) {
    echo "Erreur|commune|Aucune pierre disponible|image1.png|0";
    exit;
}

// Sélectionner une pierre aléatoire dans celles disponibles
$randomIndex = array_rand($pierres);
$selectedPierre = $pierres[$randomIndex];

// Récupérer le pseudo de l'utilisateur à partir de son email
$userPseudo = $pierreModel->getUserPseudoFromEmail($userEmail);
if (!$userPseudo) {
    echo "Erreur|commune|Utilisateur non trouvé|image1.png|0";
    exit;
}

// Vérifier si l'utilisateur a déjà cette pierre
$userHasStone = $pierreModel->userHasStone($userPseudo, $selectedPierre->nom_pierre);

// Ajouter la pierre à la collection de l'utilisateur s'il ne l'a pas déjà
if (!$userHasStone) {
    $pierreModel->addStoneToUser($userPseudo, $selectedPierre->nom_pierre);
    $isNewStone = 1; // 1 pour vrai
    $message = "Nouvelle découverte ! Cette pierre a été ajoutée à votre Géodex.";
} else {
    $isNewStone = 0; // 0 pour faux
    $message = "Vous avez déjà découvert cette pierre. Elle est déjà dans votre Géodex.";
}

// Renvoyer les informations de la pierre au format texte (séparées par |)
echo $selectedPierre->nom_pierre . "|" . 
     $rarete . "|" . 
     $message . "|" . 
     $selectedPierre->image . "|" . 
     $isNewStone;
?>