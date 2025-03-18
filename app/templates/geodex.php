<div class="geodex-container">
    <h1 class="geodex-title">Géodex</h1>
    
    <div class="geodex-grid">
        <?php
        // Supposons qu'on a un total de 25 pierres
        for ($i = 1; $i <= 25; $i++) {
            $imageIndex = (($i - 1) % 3) + 1; // Alterne entre image1, image2, image3
            
            // Simuler des pierres découvertes et non découvertes (aléatoire pour l'exemple)
            $discovered = (rand(0, 1) == 1) ? true : false;
            $cardClass = $discovered ? 'stone-card' : 'stone-card undiscovered';
            
            // Formatage du numéro comme dans Pokémon (ex: #001)
            $formattedNumber = sprintf("#%03d", $i);
            
            // Noms fictifs pour les pierres (à remplacer par des données réelles)
            $stoneNames = ['Quartz', 'Amethyste', 'Emeraude', 'Rubis', 'Saphir', 'Topaze', 'Opale', 'Diamant'];
            $stoneName = $stoneNames[($i - 1) % count($stoneNames)];
            
            echo '<a href="geodex.php?id=' . $i . '">';
            echo '  <div class="' . $cardClass . '">';
            echo '    <div class="stone-image-container">';
            echo '      <img src="../images/image' . $imageIndex . '.png" alt="Pierre ' . $i . '" class="stone-image">';
            echo '    </div>';
            echo '    <div class="stone-info">';
            echo '      <div class="stone-number">' . $formattedNumber . '</div>';
            echo '      <h3 class="stone-name">' . $stoneName . '</h3>';
            echo '    </div>';
            echo '  </div>';
            echo '</a>';
        }
        ?>
    </div>
</div>