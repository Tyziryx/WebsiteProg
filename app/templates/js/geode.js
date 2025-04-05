console.log("Système de géode chargé");

// Sélection des éléments
const imgElement = document.getElementById("geode");
const cardElement = document.querySelector(".card");
const resultTitle = document.getElementById("result-title");
const resultMessage = document.getElementById("result-message");
const resultRarity = document.getElementById("result-rarity");
const resultContainer = document.getElementById("result-container");

// Définir le chemin d'image correct et uniforme
const imagePath = "../images/";

// Cache pour stocker les images préchargées
const imageCache = {};
let preloadComplete = false;
let pierresToPreload = [];
let loadedImages = 0;

// Précharger toutes les images possibles au chargement de la page
document.addEventListener("DOMContentLoaded", function() {
    // Précharger d'abord les images d'animation essentielles
    preloadCriticalAssets();
    
    // Ensuite, récupérer la liste des pierres à précharger
    fetch('control/get_all_stones.php')
        .then(response => response.json())
        .then(data => {
            pierresToPreload = data;
            const totalImages = pierresToPreload.length;
            console.log(`Préchargement de ${totalImages} images de pierres...`);
            
            // Créer un élément de statut de chargement
            const loadingStatus = document.createElement("div");
            loadingStatus.className = "loading-status";
            loadingStatus.innerHTML = `
                <div class="loading-progress">
                    <div class="loading-bar" style="width: 0%"></div>
                </div>
                <div class="loading-text">Préparation des pierres: 0/${totalImages}</div>
            `;
            document.querySelector(".game-wrapper").appendChild(loadingStatus);
            
            // Précharger toutes les images
            pierresToPreload.forEach((pierre, index) => {
                const img = new Image();
                img.onload = function() {
                    loadedImages++;
                    imageCache[pierre.image] = img;
                    
                    // Mettre à jour la barre de progression
                    const percent = Math.floor((loadedImages / totalImages) * 100);
                    document.querySelector(".loading-bar").style.width = `${percent}%`;
                    document.querySelector(".loading-text").textContent = `Préparation des pierres: ${loadedImages}/${totalImages}`;
                    
                    // Si toutes les images sont chargées
                    if (loadedImages === totalImages) {
                        preloadComplete = true;
                        console.log("Préchargement terminé!");
                        
                        // Cacher progressivement l'indicateur de chargement
                        loadingStatus.classList.add("complete");
                        setTimeout(() => {
                            loadingStatus.style.display = "none";
                        }, 1000);
                    }
                };
                img.src = imagePath + pierre.image;
            });
        })
        .catch(error => {
            console.error("Erreur lors du préchargement:", error);
            // Continuer sans préchargement
            preloadComplete = true;
        });
});

// Précharger les ressources critiques (animations, etc.)
function preloadCriticalAssets() {
    const criticalImages = ["geode.gif", "geode_trans.gif"];
    criticalImages.forEach(img => {
        const image = new Image();
        image.src = imagePath + img;
        imageCache[img] = image;
    });
    
    // Précharger aussi les éléments d'animation
    preloadAnimation();
}

// Précharger les éléments d'animation
function preloadAnimation() {
    // Créer un flash invisible pour le précompiler
    const hiddenFlash = document.createElement("div");
    hiddenFlash.className = "flash-effect";
    hiddenFlash.style.opacity = "0";
    hiddenFlash.style.display = "none";
    document.body.appendChild(hiddenFlash);
    
    // Créer et précompiler quelques particules
    const glitterStyles = ["rare", "epique", "legendaire"];
    glitterStyles.forEach(style => {
        const particle = document.createElement("div");
        particle.className = `glitter-particle ${style}`;
        particle.style.opacity = "0";
        particle.style.display = "none";
        document.body.appendChild(particle);
    });
    
    // Supprimer ces éléments après un court délai
    setTimeout(() => {
        hiddenFlash.remove();
        document.querySelectorAll(".glitter-particle[style*='display: none']").forEach(el => el.remove());
    }, 500);
}

// Animation et gestion du tirage
imgElement.addEventListener("click", function () {
    // Éviter les clics multiples pendant l'animation
    if (cardElement.classList.contains("animating")) return;
    
    // Empêcher le clic si la carte est déjà ouverte (pierre déjà découverte)
    if (cardElement.classList.contains("opened")) {
        // Ajouter un effet visuel pour indiquer que l'utilisateur doit utiliser le bouton
        cardElement.classList.add("shake");
        setTimeout(() => cardElement.classList.remove("shake"), 500);
        
        // Attirer l'attention sur le bouton "Découvrir une autre géode"
        tryAgainButton.classList.add("highlight");
        setTimeout(() => tryAgainButton.classList.remove("highlight"), 1500);
        
        return; // Ne rien faire d'autre
    }

    // Masquer le résultat précédent s'il était visible
    resultContainer.style.display = "none";

    // Ajouter la classe pour l'animation
    cardElement.classList.add("animating");
    imgElement.src = imageCache["geode_trans.gif"] ? imageCache["geode_trans.gif"].src : imagePath + "geode_trans.gif";

    fetch('control/draw_stone.php', {
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
                // Phase de transition
                cardElement.classList.add("transitioning");
                
                // Utiliser l'image préchargée si disponible, sinon la charger maintenant
                if (imageCache[data.image]) {
                    displayResult(data);
                } else {
                    // Précharger l'image pour une transition fluide
                    const preloadImage = new Image();
                    preloadImage.src = imagePath + data.image;
                    
                    preloadImage.onload = () => {
                        // Stocker dans le cache pour utilisation future
                        imageCache[data.image] = preloadImage;
                        displayResult(data);
                    };
                }
            }, 1300);
        })
        .catch(error => {
            console.error('Erreur:', error);
            imgElement.src = imageCache["geode.gif"] ? imageCache["geode.gif"].src : imagePath + "geode.gif";
            cardElement.classList.remove("animating", "transitioning");
            
            // Afficher un message d'erreur convivial à l'utilisateur
            alert("Une erreur s'est produite lors de la découverte de pierre. Veuillez réessayer.");
        });
});

// Fonction pour afficher le résultat avec animation fluide
function displayResult(data) {
    // Ajouter un effet flash
    const flashElement = document.createElement("div");
    flashElement.className = "flash-effect";
    cardElement.appendChild(flashElement);
    
    // Préparer le conteneur de résultat pendant l'animation
    // pour qu'il soit prêt à apparaître en douceur
    resultContainer.style.display = "block";
    resultContainer.style.opacity = "0";
    resultContainer.style.transform = "translateY(30px)";
    
    // Après l'effet flash, montrer l'image finale
    setTimeout(() => {
        imgElement.src = imageCache[data.image] ? imageCache[data.image].src : imagePath + data.image;
        cardElement.classList.remove("animating", "transitioning");
        cardElement.classList.add("opened");
        
        // Retirer l'élément flash après utilisation
        setTimeout(() => {
            cardElement.removeChild(flashElement);
        }, 300);
        
        // Mettre à jour le texte de résultat
        resultTitle.textContent = data.nom_pierre;
        resultMessage.textContent = data.message;
        
        // Ajouter la classe de rareté avec animation d'apparition
        resultRarity.textContent = data.rarete;
        resultRarity.className = "rarity " + data.rarete.toLowerCase();
        
        // Créer des particules de brillance basées sur la rareté
        if (data.rarete !== "commune") {
            createGlitterEffect(cardElement, data.rarete);
        }
        
        // Animation fluide du conteneur de résultat
        // Utilisation d'une transition CSS au lieu d'une animation abrupte
        setTimeout(() => {
            // Transition douce pour l'apparition
            resultContainer.style.transition = "opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
            resultContainer.style.opacity = "1";
            resultContainer.style.transform = "translateY(0)";
            resultContainer.classList.add("visible");
        }, 300); // Réduit le délai pour une meilleure synchronisation
    }, 200);
}

// Fonction améliorée pour créer un effet de particules brillantes
function createGlitterEffect(element, rarity) {
    // Configuration des particules selon la rareté
    let particleCount, particleColors, particleSize, particleDuration;
    
    switch(rarity.toLowerCase()) {
        case "legendaire":
            particleCount = 35;
            particleColors = ['#FFD700', '#FFA500', '#FF4500', '#FFDF00'];
            particleSize = [10, 20];
            particleDuration = 3000;
            break;
        case "epique":
            particleCount = 25;
            particleColors = ['#9932CC', '#8A2BE2', '#9370DB', '#800080'];
            particleSize = [8, 16];
            particleDuration = 2500;
            break;
        case "rare":
            particleCount = 15;
            particleColors = ['#1E90FF', '#00BFFF', '#87CEFA', '#4169E1'];
            particleSize = [6, 12];
            particleDuration = 2000;
            break;
        default: // commune
            particleCount = 10;
            particleColors = ['#A0A0A0', '#C0C0C0', '#D3D3D3'];
            particleSize = [4, 8];
            particleDuration = 1500;
    }
    
    // Créer et animer les particules
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement("div");
        particle.className = "glitter-particle " + rarity.toLowerCase();
        
        // Position et trajectoire aléatoires
        const angle = Math.random() * Math.PI * 2;
        const distance = 20 + Math.random() * 150;
        const posX = Math.cos(angle) * distance;
        const posY = Math.sin(angle) * distance;
        
        // Taille et couleur aléatoires
        const size = Math.random() * (particleSize[1] - particleSize[0]) + particleSize[0];
        const color = particleColors[Math.floor(Math.random() * particleColors.length)];
        const delay = Math.random() * 0.7;
        
        // Appliquer les styles
        particle.style.left = `calc(50% + ${posX}px)`;
        particle.style.top = `calc(50% + ${posY}px)`;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.backgroundColor = color;
        particle.style.animationDelay = `${delay}s`;
        
        // Ajouter à l'élément parent
        element.appendChild(particle);
        
        // Supprimer après l'animation
        setTimeout(() => {
            if (element.contains(particle)) {
                element.removeChild(particle);
            }
        }, particleDuration + Math.random() * 1000);
    }
    
    // Effet spécial pour les légendaires et épiques
    if (rarity.toLowerCase() === "legendaire" || rarity.toLowerCase() === "epique") {
        const glow = document.createElement("div");
        glow.className = `${rarity.toLowerCase()}-glow`;
        glow.style.position = "absolute";
        glow.style.width = "200px";
        glow.style.height = "200px";
        glow.style.borderRadius = "50%";
        
        if (rarity.toLowerCase() === "legendaire") {
            glow.style.background = "radial-gradient(circle, rgba(255,215,0,0.4) 0%, rgba(255,215,0,0) 70%)";
        } else {
            glow.style.background = "radial-gradient(circle, rgba(153,50,204,0.3) 0%, rgba(153,50,204,0) 70%)";
        }
        
        glow.style.top = "50%";
        glow.style.left = "50%";
        glow.style.transform = "translate(-50%, -50%)";
        glow.style.zIndex = "4";
        glow.style.animation = "pulse 2s infinite alternate ease-in-out";
        
        element.appendChild(glow);
        
        // Ajouter un style pour l'animation pulse si nécessaire
        if (!document.getElementById("pulse-animation")) {
            const style = document.createElement("style");
            style.id = "pulse-animation";
            style.textContent = `
                @keyframes pulse {
                    0% { transform: translate(-50%, -50%) scale(0.9); opacity: 0.5; }
                    100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.2; }
                }
            `;
            document.head.appendChild(style);
        }
        
        // Supprimer l'effet après un délai
        setTimeout(() => {
            if (element.contains(glow)) {
                element.removeChild(glow);
            }
        }, 4000);
    }
    
    // Son spécial pour les légendaires (optionnel)
    if (rarity.toLowerCase() === "legendaire") {
        playDiscoverySound(rarity.toLowerCase());
    }
}

// Fonction optionnelle pour ajouter des sons
function playDiscoverySound(rarity) {
    // Cette fonction peut être implémentée plus tard pour ajouter des effets sonores
    // selon la rareté des pierres découvertes
    console.log(`Discovered ${rarity} stone!`);
}

// Bouton pour réessayer
const tryAgainButton = document.getElementById("try-again");
if (tryAgainButton) {
    tryAgainButton.addEventListener("click", function () {
        // Animation de disparition du conteneur de résultat
        resultContainer.style.transition = "opacity 0.4s ease, transform 0.4s ease";
        resultContainer.style.opacity = "0";
        resultContainer.style.transform = "translateY(20px)";
        
        setTimeout(() => {
            cardElement.classList.remove("animating", "transitioning", "opened");
            resultContainer.classList.remove("visible");
            imgElement.src = imagePath + "geode.gif";
            resultContainer.style.display = "none";
        }, 400);
    });
}