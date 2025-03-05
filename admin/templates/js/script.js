
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









