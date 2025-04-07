const switchers = [...document.querySelectorAll('.switcher')]

switchers.forEach(item => {
    item.addEventListener('click', function () {
        switchers.forEach(item => item.parentElement.classList.remove('is-active'))
        this.parentElement.classList.add('is-active')
    })
})

document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector(".form-login");
    const loginButton = document.querySelector(".btn-login");

    console.log("Formulaire détecté :", loginForm);
    console.log("Bouton détecté :", loginButton);

    if (loginForm && loginButton) {
        loginForm.addEventListener("submit", function (event) {
            console.log("Formulaire soumis !");
        });
    }
});

/**
 * Gestion des notifications et des erreurs de formulaire
 */
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des notifications standard
    const notifications = document.querySelectorAll('.notification');
    if (notifications.length > 0) {
        notifications.forEach(function(notification) {
            setTimeout(function() {
                notification.classList.add('fade-out');
                setTimeout(function() {
                    notification.style.display = 'none';
                    notification.remove(); // Suppression complète du DOM
                }, 500);
            }, 5000);
        });
    }
    
    // Gestion spécifique des erreurs de signup
    const errorContainer = document.querySelector('.error-container');
    if (errorContainer) {
        const errorMsgs = errorContainer.querySelectorAll('.notification');
        errorMsgs.forEach(function(msg) {
            setTimeout(function() {
                msg.classList.add('fade-out');
                setTimeout(function() {
                    msg.style.display = 'none';
                    msg.remove();
                }, 500);
            }, 5000);
        });
    }
    
    // Fonction globale pour afficher des notifications dynamiquement
    window.showNotification = function(status, message) {
        // Supprimer les notifications existantes
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(function(note) {
            note.remove();
        });
        
        // Créer la nouvelle notification
        const notification = document.createElement('div');
        notification.className = 'notification ' + status;
        notification.textContent = message;
        
        document.body.prepend(notification);
        
        // Configurer la disparition automatique
        setTimeout(function() {
            notification.classList.add('fade-out');
            setTimeout(function() {
                notification.style.display = 'none';
                notification.remove();
            }, 500);
        }, 5000);
    };
});
