// Fonction pour activer l'édition d'un champ
function editField(field) {
    let textElement = document.getElementById(`${field}-text`);
    let inputElement = document.getElementById(`${field}-input`);

    // Basculer entre affichage texte et champ d'édition
    if (inputElement.style.display === "none") {
        inputElement.value = textElement.innerText;
        textElement.style.display = "none";
        inputElement.style.display = "inline-block";
        inputElement.focus();
    } else {
        textElement.style.display = "inline-block";
        inputElement.style.display = "none";
    }
}

// Fonction pour enregistrer les modifications
function saveChanges() {
    let usernameInput = document.getElementById("username-input");
    let emailInput = document.getElementById("email-input");
    let passwordInput = document.getElementById("password-input");

    let usernameText = document.getElementById("username-text");
    let emailText = document.getElementById("email-text");
    let passwordText = document.getElementById("password-text");

    // Mettre à jour les valeurs affichées
    if (usernameInput.style.display === "inline-block") {
        usernameText.innerText = usernameInput.value;
    }
    if (emailInput.style.display === "inline-block") {
        emailText.innerText = emailInput.value;
    }
    if (passwordInput.style.display === "inline-block") {
        passwordText.innerText = "••••••••"; // Ne pas afficher le mot de passe en clair
    }

    // Masquer les champs de saisie et afficher les valeurs mises à jour
    usernameText.style.display = "inline-block";
    usernameInput.style.display = "none";

    emailText.style.display = "inline-block";
    emailInput.style.display = "none";

    passwordText.style.display = "inline-block";
    passwordInput.style.display = "none";

    // Affichage du message de confirmation
    document.getElementById("message").textContent = "Profil mis à jour avec succès !";

    // Simuler un enregistrement dans une BDD
    console.log("Nom d'utilisateur :", usernameText.innerText);
    console.log("Email :", emailText.innerText);
    console.log("Mot de passe :", passwordInput.value ? "Modifié" : "Non modifié");
}
