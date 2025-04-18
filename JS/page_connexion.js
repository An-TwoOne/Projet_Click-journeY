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

   

    

}