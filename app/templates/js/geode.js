console.log("Système de géode chargé");

// Sélection des éléments
const imgElement = document.getElementById("geode");
const cardElement = document.querySelector(".card");
const resultTitle = document.getElementById("result-title");
const resultMessage = document.getElementById("result-message");
const resultRarity = document.getElementById("result-rarity");

// Définir le chemin d'image correct et uniforme
const imagePath = "../../images/";

// Animation et gestion du tirage
imgElement.addEventListener("click", function() {
    // Éviter les clics multiples pendant l'animation
    if (cardElement.classList.contains("animating")) return;
    
    // Ajouter la classe pour l'animation
    cardElement.classList.add("animating");
    imgElement.src = imagePath + "geode_trans.gif";
    
    // Faire la requête AJAX pour tirer une pierre aléatoire
    fetch('../control/draw_stone.php', {
        method: 'POST'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        return response.text();
    })
    .then(responseText => {
        // Interpréter la réponse au format texte
        let result = responseText.split('|');
        
        // Créer un objet à partir des données texte
        let data = {
            nom_pierre: result[0] || "Pierre inconnue",
            rarete: result[1] || "commune",
            message: result[2] || "Description non disponible",
            image: result[3] || "image1.png",
            isNew: result[4] === "1" // Si le 5ème élément est "1", c'est une nouvelle pierre
        };
        
        // Après un délai pour l'animation
        setTimeout(() => {
            // Afficher les résultats avec le bon chemin d'image uniforme
            imgElement.src = imagePath + data.image;
            cardElement.classList.add("opened");
            
            // Mettre à jour le texte de résultat
            resultTitle.textContent = data.nom_pierre;
            resultMessage.textContent = data.message;
            
            // Ajouter la classe de rareté
            resultRarity.textContent = data.rarete;
            resultRarity.className = "rarity " + data.rarete.toLowerCase();
            
            // Afficher le conteneur de résultat
            document.getElementById("result-container").style.display = "block";
        }, 1500); // Temps pour l'animation
    })
    .catch(error => {
        console.error('Erreur:', error);
        imgElement.src = imagePath + "geode.gif";
        cardElement.classList.remove("animating");
        
        // Afficher un message d'erreur convivial à l'utilisateur
        alert("Une erreur s'est produite lors de la découverte de pierre. Veuillez réessayer.");
    });
});

// Bouton pour réessayer
const tryAgainButton = document.getElementById("try-again");
if (tryAgainButton) {
    tryAgainButton.addEventListener("click", function() {
        cardElement.classList.remove("animating", "opened");
        imgElement.src = imagePath + "geode.gif";
        document.getElementById("result-container").style.display = "none";
    });
}