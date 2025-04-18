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
                    mdpCompteur.style.color = "white";
                }
            } else if (mdpCompteur) {
                mdpCompteur.remove();
                mdpCompteur = null;
            }
        });
    }
    
}