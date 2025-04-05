<div class="container">
    <h1>Découverte de Géode</h1>
    <p>Clique sur la géode pour découvrir une pierre précieuse !</p>
    
    <div class="game-wrapper">
        <div class="card">
            <img id="geode" src="../images/geode.gif" alt="Géode à ouvrir">
        </div>

        <div id="result-container" style="display: none;">
            <h2 id="result-title">Nom de la pierre</h2>
            <span id="result-rarity" class="rarity">Rareté</span>
            <p id="result-message">Description de la pierre</p>
            <button id="try-again" class="btn-primary">Découvrir une autre géode</button>
        </div>
    </div>

    <div class="rarity-info">
        <h3>Chances de découverte :</h3>
        <ul>
            <li><span class="rarity commune">Commune</span> - 70%</li>
            <li><span class="rarity rare">Rare</span> - 20%</li>
            <li><span class="rarity epique">Épique</span> - 8%</li>
            <li><span class="rarity legendaire">Légendaire</span> - 2%</li>
        </ul>
    </div>
</div>

<script src="templates/js/geode.js"></script>
