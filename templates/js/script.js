// Version nettoyée - supprime les duplications et garde seulement les fonctionnalités essentielles

// Défilement pour changer les images
document.addEventListener("scroll", () => {
    const scrollY = window.scrollY;
    const images = document.querySelectorAll(".scroll-image");
    const contents = document.querySelectorAll(".content-wrapper");
    const indexBars = document.querySelectorAll(".index-bar");

    if (images.length === 0) return;

    // Calcul de l'index basé sur le défilement
    let index = Math.min(Math.floor(scrollY / 1000), images.length - 1);

    // Activer/désactiver les éléments
    images.forEach((img, i) => img.classList.toggle("active", i === index));
    contents.forEach((content, i) => content.classList.toggle("active", i === index));
    indexBars.forEach((bar, i) => bar.classList.toggle("active", i === index));
});

// Clic sur les barres d'index
document.querySelectorAll(".index-bar").forEach(bar => {
    bar.addEventListener("click", (e) => {
        let targetIndex = parseInt(e.target.dataset.index);
        window.scrollTo({
            top: targetIndex * 999,
            behavior: 'smooth'
        });
    });
});

// Section fixe au défilement
document.addEventListener("scroll", () => {
    const scrollSection = document.querySelector(".fixed-section");
    if (!scrollSection) return;
    
    const hero = document.querySelector(".hero");
    if (!hero) return;
    
    const heroHeight = hero.offsetHeight;
    const spacer = document.querySelector(".spacer");
    const endFixedPoint = heroHeight + (spacer ? spacer.offsetHeight : 0);

    if (window.scrollY >= heroHeight && window.scrollY < endFixedPoint) {
        scrollSection.classList.add("fixed");
    } else {
        scrollSection.classList.remove("fixed");
    }
});

// Navigation mobile et header
document.addEventListener("DOMContentLoaded", function() {
    const navbar = document.querySelector('.navbar');
    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const navLinks = document.querySelector('.nav-links');
    const overlay = document.querySelector('.overlay');
    
    if (navbar && mobileNavToggle && navLinks && overlay) {
        let isMenuOpen = false;
        
        // Effet de défilement pour la navbar
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Toggle du menu mobile
        function toggleMenu() {
            isMenuOpen = !isMenuOpen;
            mobileNavToggle.classList.toggle('active');
            navLinks.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = isMenuOpen ? 'hidden' : '';
        }
        
        mobileNavToggle.addEventListener('click', toggleMenu);
        
        // Fermer le menu mobile sur clic des liens
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                if (isMenuOpen) toggleMenu();
            });
        });
        
        // Fermer le menu avec la touche Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isMenuOpen) toggleMenu();
        });
        
        // Ajustement pour le redimensionnement de l'écran
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && isMenuOpen) {
                toggleMenu();
            }
        });
    }
    
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            faqItem.classList.toggle('active');
        });
    });

    // Gestion de la FAQ - modifier pour que le clic fonctionne sur toute la carte
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(function(item) {
        item.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
});

