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

    const nouveauMdp = document.querySelector("#nouveau_mdp");

    if (nouveauMdp) {
        let mdpCompteur = null;
        const mdpConteneur = nouveauMdp.closest(".mdp-conteneur");

        nouveauMdp.addEventListener("input", function () {
            const longueur = nouveauMdp.value.length;

            if (longueur > 0) {
                if (!mdpCompteur) {
                    mdpCompteur = document.createElement("span");
                    mdpCompteur.id = "mdp-compteur";
                    mdpConteneur.insertAdjacentElement("afterend", mdpCompteur);
                }

                mdpCompteur.textContent = `${longueur} / 8 caractères`;
                if (longueur < 8) {
                    mdpCompteur.style.color = "red";
                } else {
                    mdpCompteur.style.color = "var(--blanc)";
                }
            } else if (mdpCompteur) {
                mdpCompteur.remove();
                mdpCompteur = null;
            }
        });
    }


    const formul = document.querySelector("form");
    const nom_entree = formul.querySelector("#name");
    const prenom_entree = formul.querySelector("#prenom");
    const age_entree = formul.querySelector("#age");
    const email_entree = formul.querySelector("#email");
    const mdp_entree = formul.querySelector("#nouveau_mdp");
    const confirmation_entree = formul.querySelector("#confirmation");
    const mobile_entree = formul.querySelector("#telephone");
    


    let message_erreur = document.querySelector(".erreur_message");
    if (!message_erreur) {
        message_erreur = document.createElement("p");
        message_erreur.className = "erreur_message";
        formul.querySelector("fieldset").appendChild(message_erreur);
    }

    formul.addEventListener("submit", function (even) {
        even.preventDefault();

        const nom = nom_entree.value.trim();
        const prenom = prenom_entree.value.trim();
        const age = parseInt(age_entree.value.trim(), 10);
        const email = email_entree.value.trim();
        const mdp = mdp_entree.value.trim();
        const confirmation = confirmation_entree.value.trim();
        const mobile = mobile_entree.value.trim();
        

        let message = "";

        if ( !email || !mdp || !confirmation || !mobile || !age) {
            message = "Tous les champs doivent être remplis.";
        } 
        else if  (!nom) {
            message = "Veuillez entrer un nom valide.";
        } else if (!prenom) {
            message = "Veuillez entrer un prénom valide.";
        }
        
        
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            message = "L'adresse mail n’est pas valide.";
        } else if (mdp.length < 8) {
            message = "Le mot de passe doit contenir au moins 8 caractères.";
        } else if (mdp !== confirmation) {
            message = "Les mots de passe ne sont pas identiques.";
        } else if (!/^\d{10,}$/.test(mobile)) {
            message = "Le numéro de téléphone doit contenir au moins 10 chiffres.";
        } 

        if (message) {
            message_erreur.textContent = message;
        } else {
            message_erreur.textContent = "";
            formul.submit();
        }
    });
    
}