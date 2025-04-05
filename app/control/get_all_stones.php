<?php
// filepath: /home/nas-wks01/users/uapv2401411/Donnees_itinerantes_depuis_serveur_pedagogique/public_html/app/control/get_all_stones.php

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/Pierre.php';

// Définir l'en-tête pour le JSON
header('Content-Type: application/json');

// Créer une instance et récupérer les données
$pierreModel = new \bd\Pierre();
$pierres = $pierreModel->getAllPierres();

// Préparer un tableau pour le JSON
$result = [];
foreach ($pierres as $pierre) {
    $result[] = [
        'nom_pierre' => $pierre->nom_pierre,
        'description' => $pierre->description,
        'rarete' => $pierre->rarete,
        'image' => $pierre->image
    ];
}

// Retourner le JSON
echo json_encode($result);