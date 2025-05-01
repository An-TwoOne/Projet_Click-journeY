document.addEventListener("DOMContentLoaded", pageChargee);

function pageChargee() {
    const btnenregistrer = document.querySelector(".enregistrer");
    const formul = document.querySelector("form");

    const lignes = document.querySelectorAll("#contenu");

    
    function attentemodif(checkbox) {
        checkbox.disabled = true;
        btnenregistrer.disabled = true;
    
        setTimeout(function () {
            checkbox.disabled = false;
            btnenregistrer.disabled = false;
        }, 1000); 
    }

    lignes.forEach(function (ligne) {
        const vipCheckbox = ligne.querySelector(".check_vip");
        const excluCheckbox = ligne.querySelector(".check_exclu");

        vipCheckbox.addEventListener("change", function () {
            if (vipCheckbox.checked) {
                excluCheckbox.checked = false;
            }
            attentemodif(vipCheckbox);
        });

        excluCheckbox.addEventListener("change", function () {
            if (excluCheckbox.checked) {
                vipCheckbox.checked = false;
            }
            attentemodif(excluCheckbox);
        });
    });

    formul.addEventListener("submit", function (even) {
        even.preventDefault(); 

        btnenregistrer.disabled = true;
        btnenregistrer.style.backgroundColor = "#111111a1";
        btnenregistrer.style.color = "#f2f0f0a1";

        setTimeout(function () {
            formul.submit(); 
        }, 1500);
    });

   

}
