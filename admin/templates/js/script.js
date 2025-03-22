// Attendre que le document soit complètement chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('FAQ script loading...');
    
    // Gestion de la FAQ - clic sur toute la carte
    const faqItems = document.querySelectorAll('.faq-item');
    
    if (faqItems.length > 0) {
        console.log(`Found ${faqItems.length} FAQ items`);
        
        faqItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
                // Empêcher la propagation pour éviter les conflits
                event.stopPropagation();
                this.classList.toggle('active');
                console.log('FAQ item clicked:', this.querySelector('.faq-question').textContent.trim());
            });
        });
        
        // Empêcher que le clic sur la réponse referme la carte
        const faqAnswers = document.querySelectorAll('.faq-answer');
        faqAnswers.forEach(function(answer) {
            answer.addEventListener('click', function(event) {
                // Empêcher la propagation pour que le clic sur la réponse ne ferme pas la carte
                event.stopPropagation();
            });
        });
    } else {
        console.log('No FAQ items found on this page');
    }
});