document.addEventListener("scroll", () => {
    const scrollY = window.scrollY;
    const images = document.querySelectorAll(".scroll-image");
    const titles = document.querySelectorAll(".title-content");
    const texts = document.querySelectorAll(".text-content");
    const indexBars = document.querySelectorAll(".index-bar");

    let index = Math.min(Math.floor(scrollY / 1000), images.length - 1);

    images.forEach((img, i) => img.classList.toggle("active", i === index));
    titles.forEach((title, i) => title.classList.toggle("active", i === index));
    texts.forEach((txt, i) => txt.classList.toggle("active", i === index));
    indexBars.forEach((bar, i) => bar.classList.toggle("active", i === index));
});

// CLIC SUR LES BARRES POUR CHANGER D'ÉTAPE
document.querySelectorAll(".index-bar").forEach(bar => {
    bar.addEventListener("click", (e) => {
        let targetIndex = parseInt(e.target.dataset.index);
        window.scrollTo({
            top: targetIndex * 500, // Ajuste selon la hauteur de ton effet
            behavior: "smooth"
        });
    });
});

document.addEventListener("scroll", () => {
    const scrollSection = document.querySelector(".fixed-section");
    const heroHeight = document.querySelector(".hero").offsetHeight;

    if (window.scrollY >= heroHeight) {
        scrollSection.classList.add("fixed");
    } else {
        scrollSection.classList.remove("fixed");
    }
});