document.addEventListener("DOMContentLoaded", function () {
    const editIcons = document.querySelectorAll(".edit-icon");

    function AfficherBoutonEnregistrer() {
        const saveButton = document.querySelector(".save");
        if (saveButton) {
            saveButton.style.display = "inline-block";
        }
    }

  
    const eyeIcons = document.querySelectorAll(".aff-mdp");
    eyeIcons.forEach(icon => icon.style.display = "none");

    eyeIcons.forEach(function (eyeIcon) {
        eyeIcon.addEventListener("click", function () {
            const parent = eyeIcon.closest(".mdp-conteneur");
            const input = parent.querySelector("input");

            if (input.type === "password") {
                input.type = "text";
                eyeIcon.src = "contenu_css/oeil_ferme_icon.png";
            } else {
                input.type = "password";
                eyeIcon.src = "contenu_css/oeil_icon.png";
            }
        });
    });

    editIcons.forEach(function (icon) {
        icon.addEventListener("click", function () {
            let input = icon.previousElementSibling;

            
            if (icon.closest(".mdp-conteneur")) {
                input = icon.closest(".mdp-conteneur").querySelector("input");
            }

            if (!input || !input.hasAttribute("readonly")) return;

            const valeuroriginale = input.value;
            input.dataset.valeuroriginale = valeuroriginale;
            input.removeAttribute("readonly");
            input.focus();

            icon.style.display = "none";

            
            const parent = icon.closest(".mdp-conteneur");
            if (parent) {
                const eye = parent.querySelector(".aff-mdp");
                if (eye) {
                    eye.style.display = "inline-block";
                }
            }

            const validerBtn = document.createElement("button");
            validerBtn.textContent = "✓";
            validerBtn.className = "btn-valider";
            validerBtn.type = "button";

            const annulerBtn = document.createElement("button");
            annulerBtn.textContent = "✕";
            annulerBtn.className = "btn-annuler";
            annulerBtn.type = "button";

            validerBtn.addEventListener("click", function () {
                input.setAttribute("readonly", true);
                validerBtn.remove();
                annulerBtn.remove();
                icon.style.display = "inline-block";

                
                const parent = icon.closest(".mdp-conteneur");
                if (parent) {
                    const eye = parent.querySelector(".aff-mdp");
                    if (eye) eye.style.display = "none";
                }

                AfficherBoutonEnregistrer();
                if (input.id === "nouveau_mdp" && mdpCompteur) {
                    mdpCompteur.textContent = "";
                }
                
            });

            annulerBtn.addEventListener("click", function () {
                input.value = input.dataset.valeuroriginale;
                input.setAttribute("readonly", true);
                validerBtn.remove();
                annulerBtn.remove();
                icon.style.display = "inline-block";

                
                const parent = icon.closest(".mdp-conteneur");
                if (parent) {
                    const eye = parent.querySelector(".aff-mdp");
                    if (eye) eye.style.display = "none";
                }

                if (input.id === "nouveau_mdp" && mdpCompteur) {
                    mdpCompteur.textContent = "";
                }
            });

            icon.parentNode.insertBefore(validerBtn, icon.nextSibling);
            icon.parentNode.insertBefore(annulerBtn, validerBtn.nextSibling);
        });
    });

    const nouveauMdp = document.querySelector("#nouveau_mdp");
    const mdpCompteur = document.querySelector("#mdp-compteur");

    if (nouveauMdp && mdpCompteur){
        nouveauMdp.addEventListener("input", function () {
            const longueur = nouveauMdp.value.length;
            mdpCompteur.textContent = `${longueur} / 8 caractères`;
            if (longueur < 8) {
                mdpCompteur.style.color = "red";
            } else {
                mdpCompteur.style.color = "white";
            }
        });
    }



});
