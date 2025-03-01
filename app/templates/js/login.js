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

