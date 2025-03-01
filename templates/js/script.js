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
            top: targetIndex * 999, // 1000-1 -> X de scrollY/ X
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

//HEADER 
//Réccupéré sur codepen.io
//https://codepen.io/themrsami/details/ogvedxR

const navbar = document.querySelector('.navbar');
const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
const navLinks = document.querySelector('.nav-links');
const overlay = document.querySelector('.overlay');
let isMenuOpen = false;

// Scroll effect
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});


// Toggle mobile menu
function toggleMenu() {
    isMenuOpen = !isMenuOpen;
    mobileNavToggle.classList.toggle('active');
    navLinks.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = isMenuOpen ? 'hidden' : '';
}

mobileNavToggle.addEventListener('click', toggleMenu);

// Close mobile menu when clicking a link
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        if (isMenuOpen) toggleMenu();
    });
});

// Close menu on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isMenuOpen) toggleMenu();
});

// Prevent scroll when menu is open
window.addEventListener('resize', () => {
    if (window.innerWidth > 768 && isMenuOpen) {
        toggleMenu();
    }
});


//gère la faq
document.addEventListener("DOMContentLoaded", function () {
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(function (question) {
        question.addEventListener('click', function () {
            const faqItem = this.parentElement; // Récupère le parent .faq-item
            faqItem.classList.toggle('active');
        });
    });
});









