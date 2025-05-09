<?php
// Inclure la classe Pierre au début du fichier
require_once __DIR__ . '/../../config/Pierre.php';
?>
<div class="geodex-container">
    <h1 class="geodex-title">Géodex</h1>
    
    <!-- Ajouter cette section pour montrer les pourcentages de rareté -->
    <div class="rarity-info">
        <h3>Chances de découverte :</h3>
        <ul>
            <li><span class="rarity commune">Commune</span> - 70%</li>
            <li><span class="rarity rare">Rare</span> - 20%</li>
            <li><span class="rarity epique">Épique</span> - 8%</li>
            <li><span class="rarity legendaire">Légendaire</span> - 2%</li>
        </ul>
    </div>
    
    <div class="geodex-grid">
        <?php
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['email'])) {
            echo '<div class="error-message">Vous devez être connecté pour voir votre Géodex.</div>';
        } else {
            // Récupérer le pseudo de l'utilisateur à partir de son email
            $pierreModel = new \bd\Pierre();
            $userPseudo = $pierreModel->getUserPseudoFromEmail($_SESSION['email']);
            
            if (!$userPseudo) {
                echo '<div class="error-message">Impossible de trouver votre compte. Veuillez vous reconnecter.</div>';
            } else {
                // Récupérer toutes les pierres disponibles dans la base de données
                $allStones = $pierreModel->getAllPierres();
                
                // Si aucune pierre n'est disponible, afficher un message
                if (empty($allStones)) {
                    echo '<div class="error-message">Aucune pierre n\'est disponible dans le Géodex pour le moment.</div>';
                } else {
                    // Récupérer les pierres que l'utilisateur a découvertes
                    $userStones = $pierreModel->getUserStones($userPseudo);
                    
                    // Extraire les noms des pierres découvertes pour faciliter la comparaison
                    $discoveredStoneNames = [];
                    foreach ($userStones as $stone) {
                        $discoveredStoneNames[] = $stone->nom_pierre;
                    }
                    
                    // Afficher toutes les pierres disponibles

                    $i = 1;
                    foreach ($allStones as $stone) {
                        // Vérifier si l'utilisateur a découvert cette pierre
                        $discovered = in_array($stone->nom_pierre, $discoveredStoneNames);
                        $cardClass = $discovered ? 'stone-card' : 'stone-card undiscovered';
                        
                        // Formatage du numéro comme dans Pokémon (ex: #001)
                        $formattedNumber = sprintf("#%03d", $i);
                        
                        // Ajouter l'attribut data-rarity pour le style CSS
                        echo '<div class="' . $cardClass . '"' . ($discovered ? ' data-rarity="'.$stone->rarete.'"' : '') . '>';
                        echo '  <div class="stone-image-container">';
                        // Utiliser l'image réelle pour toutes les pierres, mais appliquer un style CSS pour les non-découvertes
                        if ($discovered) {
                            echo '    <a href="geodex/' . urlencode($stone->nom_pierre) . '">';
                        }
                        echo '      <img src="../images/' . $stone->image . '" alt="' . 
                             ($discovered ? $stone->nom_pierre : 'Pierre non découverte') . '" class="stone-image">';
                        if ($discovered) {
                            echo '    </a>';
                        }                        echo '  </div>';
                        echo '  <div class="stone-info">';
                        echo '    <div class="stone-number">' . $formattedNumber . '</div>';
                        if ($discovered) {
                            echo '    <h3 class="stone-name">' . $stone->nom_pierre . '</h3>';
                            // Afficher plus d'informations pour les pierres découvertes si désiré
                            echo '    <span class="stone-rarity  ' . $stone->rarete . '">' . $stone->rarete . '</span>';
                        } else {
                            // Masquer le nom pour les pierres non découvertes
                            echo '    <h3 class="stone-name">???</h3>';
                            echo '    <p class="stone-rarity">Non découverte</p>';
                        }
                        echo '  </div>';
                        echo '</div>';
                        
                        $i++;
                    }
                }
            }
        }
        ?>
    </div>
</div>