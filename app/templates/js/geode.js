// Tableau des images possibles
const images = [
    "../images/image1.png",
    "../images/image2.png",
    "../images/image3.png",
];

// Sélection de l'image par défaut
const imgElement = document.getElementById("geode");

// Ajout de l'événement au clic
imgElement.addEventListener("click", () => {
    // Sélection aléatoire d'une image
    const randomIndex = Math.floor(Math.random() * images.length);
    imgElement.src = images[randomIndex];
});