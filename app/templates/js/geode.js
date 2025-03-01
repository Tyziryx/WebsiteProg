// Tableau des images possibles
const images = [
    "/AMS/app/images/image1.png",
    "/AMS/app/images/image2.png",
    "/AMS/app/images/image3.png",
];

// Sélection de l'élément
const imgElement = document.getElementById("geode");
const cardElement = document.querySelector(".card");

// Ajout de l'événement au clic
imgElement.addEventListener("click", () => {
    // Sélection aléatoire d'une image
    const randomIndex = Math.floor(Math.random() * images.length);
    imgElement.src = images[randomIndex];

    // Ajouter la classe "clicked" après le premier clic
    cardElement.classList.add("clicked");
});
