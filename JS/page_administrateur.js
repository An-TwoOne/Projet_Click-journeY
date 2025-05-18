document.addEventListener("DOMContentLoaded", pageChargee);

function pageChargee() {
    const btnenregistrer = document.querySelector(".enregistrer");
    const formul = document.querySelector("form");
    const lignes = document.querySelectorAll("#contenu");

    
    function attentemodif() {
        btnenregistrer.disabled = true;
        setTimeout(function () {
            btnenregistrer.disabled = false;
        }, 1000); 
    }

    lignes.forEach(function (ligne) {


        const vipCheckbox = ligne.querySelector(".check_vip");
        const excluCheckbox = ligne.querySelector(".check_exclu");

        function envoyerMAJ(checkbox, statut) {
            const userId = checkbox.value;


            const chargement = document.createElement("img");
            chargement.src = "../contenu_css/chargement_anim.gif";
            chargement.classList.add("chargement-icon");
            

            const parent = checkbox.parentNode;
            checkbox.style.display = "none";
            parent.appendChild(chargement);
           
            requestAnimationFrame(() => {
            fetch("../maj_statut_utilisateur.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: userId, statut: statut })
            })
            .then((res) => {
                if (!res.ok) throw new Error("Erreur serveur");
                return res.json();
            })
            .then((data) => {
                console.log(data.message);
            })
            .catch((err) => {
                alert("Erreur lors de la mise à jour");
                console.error(err);
            })
            .finally(() => {
                chargement.remove();             
                checkbox.style.display = ""; 
            });

            });
        }

        vipCheckbox.addEventListener("change", function () {
            if (vipCheckbox.checked) {
                excluCheckbox.checked = false;
                envoyerMAJ(vipCheckbox, "VIP");
            }else {
                envoyerMAJ(vipCheckbox, "null");
            }
            
            attentemodif();
        });

        excluCheckbox.addEventListener("change", function () {
            if (excluCheckbox.checked) {
                vipCheckbox.checked = false;
                envoyerMAJ(excluCheckbox, "Exclu");
            }else{
                envoyerMAJ(excluCheckbox, "null");
            }
            attentemodif();
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
