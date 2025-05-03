document.addEventListener("DOMContentLoaded", pageChargee);
function pageChargee() { 

    const oeilIcons = document.querySelectorAll(".aff-mdp");

    oeilIcons.forEach(function(icon) {
        icon.style.display = "inline-block";
    });

    oeilIcons.forEach(function (icon) {
        icon.addEventListener("click", function () {
            const parent = icon.closest(".mdp-conteneur");
            const input = parent.querySelector("input");

            if (input.type === "password") {
                input.type = "text";
                icon.src = "contenu_css/oeil_ferme_icon_blanc.png";
            } else {
                input.type = "password";
                icon.src = "contenu_css/oeil_icon_blanc.png";
            }
        });
    });


    const formul = document.querySelector("form");
    const email_entree = formul.querySelector("#email");
    const mdp_entree = formul.querySelector("#Mot_de_passe");

    let message_erreur = document.querySelector(".erreur_message");

    if (!message_erreur) {
        message_erreur = document.createElement("p");
        message_erreur.className = "erreur_message";
        formul.querySelector("fieldset").appendChild(message_erreur);
    }

    formul.addEventListener("submit", function(even) {
        even.preventDefault(); 

        const email = email_entree.value.trim();
        const mdp = mdp_entree.value.trim();
        let message = "";

        if (!mdp || !email) {
            message = "Tous les champs doivent être remplis.";
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            message = "L'adresse mail n’est pas valide.";
        } else if (mdp.length < 8) {
            message = "Le mot de passe ne contient pas au moins 8 caractères.";
        }

        if (message) {
            message_erreur.textContent = message;
        } else {
            message_erreur.textContent = "";
            formul.submit();
        }
    });

}