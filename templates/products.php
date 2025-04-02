<?php
// En haut de votre fichier
require_once __DIR__ . '/../config/Pierre.php';

// Créer une instance de la classe Pierre
$pierreModel = new \bd\Pierre();

// Récupérer les pierres communes
$pierresCommunes = $pierreModel->getPierresByRarete('commune');

// Assurez-vous que $racine_path est défini

?>

<section class="fixed-section">
    <div class="scroll-index">
        <?php 
        // Générer dynamiquement les index en fonction du nombre de pierres
        foreach ($pierresCommunes as $index => $pierre) {
            $active = ($index === 0) ? 'active' : '';
            echo "<span class='index-bar $active' data-index='" . ($index + 1) . "'></span>";
        }
        ?>
    </div>
    
    <div class="image-container">
        <?php 
        // Générer dynamiquement les images
        foreach ($pierresCommunes as $index => $pierre) {
            $active = ($index === 0) ? 'active' : '';
            echo "<img src='" . $racine_path . "images/" . $pierre->image . "' ";
            echo "alt='" . $pierre->nom_pierre . "' class='scroll-image $active'>";
        }
        ?>
    </div>
    
    <div class="text-container">
        <?php 
        // Générer dynamiquement les textes
        foreach ($pierresCommunes as $index => $pierre) {
            $active = ($index === 0) ? 'active' : '';
            echo "<div class='content-wrapper $active'>";
            echo "<h2 class='title-content'>" . $pierre->nom_pierre . "</h2>";
            echo "<p class='text-content'>" . $pierre->description . "</p>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<!-- section vide pour permettre le scroll -->
<section class="spacer"><div class="end-card">
        Merci pour votre enthousiasme
    </div></section>