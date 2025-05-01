document.addEventListener("DOMContentLoaded", pageChargee);

function pageChargee() {

     const formul = document.querySelector('#filtre_recherche');
     const voyages = document.querySelectorAll('.contenu');

     formul.addEventListener('submit', function (even) {
          even.preventDefault();


          const duree = formul.duree.value;
          const prixMax = parseInt(formul.prix.value);
          const univers = formul.univers.value;

          const experience_input = formul.querySelector('input[name="experience"]:checked');
          let experience = null;
          if (experience_input !== null) {
               experience = experience_input.value;
          }

          const periode_input = formul.querySelectorAll('input[name="periode"]:checked');
          const periodes = [];
          for (let i = 0; i < periode_input.length; i++) {
               periodes.push(periode_input[i].value);
          }


          const promotion_input = formul.querySelector('input[name="promotion"]:checked');
          let promotion = null;
          if (promotion_input !== null) {
               promotion = promotion_input.value;
          }


          const equipement_input = formul.querySelector('input[name="equipement"]:checked');
          let equipement = null;
          if (equipement_input !== null) {
               equipement = equipement_input.value;
          }


          const type_input = formul.querySelectorAll('input[name="type"]:checked');
          const types = [];
          for (let i = 0; i < type_input.length; i++) {
               types.push(type_input[i].value);
          }




          voyages.forEach(function (voyage) {


               let visible = true;


               var valeur_duree = [];
               if (voyage.dataset.duree) {
                    valeur_duree = voyage.dataset.duree.split(',');
               }

               var valeur_prix = parseInt(voyage.dataset.prix);

               var valeur_experience = [];
               if (voyage.dataset.experience) {
                    valeur_experience = voyage.dataset.experience.split(',');
               }

               var valeur_periode = voyage.dataset.periode;
               var valeur_promotion = voyage.dataset.promotion;

               var valeur_equipement = [];
               if (voyage.dataset.equipement) {
                    valeur_equipement = voyage.dataset.equipement.split(',');
               }

               var valeur_type = [];
               if (voyage.dataset.type) {
                    valeur_type = voyage.dataset.type.split(',');
               }

               var valeur_univers = [];
               if (voyage.dataset.univers) {
                    valeur_univers = voyage.dataset.univers.split(',');
               }


               if (duree && !valeur_duree.includes(duree)) {
                    visible = false;
               }

               if (prixMax && valeur_prix > prixMax) {
                    visible = false;
               }

               if (experience && !valeur_experience.includes(experience)) {
                    visible = false;
               }

               if (periodes.length > 0 && !periodes.includes(valeur_periode)) {
                    visible = false;
               }

               if (promotion && valeur_promotion !== promotion) {
                    visible = false;
               }

               if (equipement && !valeur_equipement.includes(equipement)) {
                    visible = false;
               }

               var type_comparaison = false;
               if (types.length > 0) {
                    for (var i = 0; i < types.length; i++) {
                         if (valeur_type.includes(types[i])) {
                              type_comparaison = true;
                              break;
                         }
                    }
                    if (!type_comparaison) {
                         visible = false;
                    }
               }

               if (univers !== "Tous" && !valeur_univers.includes(univers)) {
                    visible = false;
               }


               if (visible) {
                    voyage.style.display = "block";
               } else {
                    voyage.style.display = "none";
               }


          });
     });


     const entree_prix = document.querySelector('#prix');
     const prix_aff = document.querySelector('#aff_prix');

     entree_prix.addEventListener('input', function () {
          prix_aff.textContent = entree_prix.value + "€";
     });



}


