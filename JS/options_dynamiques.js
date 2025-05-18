// options_dynamiques.js - Système de chargement dynamique des options de voyage

// Structure qui contiendra toutes les options disponibles
let toutesOptions = {};
let dependancesOptions = {};
let optionsSelectionnees = [];

// Fonction pour initialiser les données
function initialiserDonnees() {
    
    fetch('données_json/options.json')
        .then(response => response.json())
        .then(data => {
            
            toutesOptions = data;
            
     
            analyserDependances();
            
           
            chargerSelectionsPrecedentes();
            
           
            initialiserConteneurs();
        })
        .catch(error => {
            console.error('Erreur lors du chargement des options:', error);
            afficherMessageErreur('Impossible de charger les options du voyage. Veuillez réessayer.');
        });
}

function analyserDependances() {
    
    
    const voyage = document.querySelector('form').getAttribute('data-voyage');
    
    if (!toutesOptions[voyage]) return;
    
    dependancesOptions = {
        transport: {
            
            "Voiture autonome volée": {
                hebergement: ["Megabuilding", "Hotel Holo"]
            },
            "Moto Hover": {
                hebergement: ["Capsule Futuriste autonome"]
            },
            "Drone-taxi": {
                hebergement: ["Megabuilding", "Hotel Holo", "Capsule Futuriste autonome"]
            }
        }
    };
}

// Fonction pour charger les sélections précédentes depuis sessionStorage
function chargerSelectionsPrecedentes() {
    const selectionsPrecedentes = JSON.parse(sessionStorage.getItem('selectedOptions') || '[]');
    if (selectionsPrecedentes.length > 0) {
        optionsSelectionnees = selectionsPrecedentes;
    }
}


function initialiserConteneurs() {
    const voyage = document.querySelector('form').getAttribute('data-voyage');
    
    if (!toutesOptions[voyage]) return;
    
    for (const etapeKey in toutesOptions[voyage][0]) {
      
        const etapeSection = creerSectionEtape(etapeKey);
        
       
        for (const typeKey in toutesOptions[voyage][0][etapeKey][0]) {
            const options = toutesOptions[voyage][0][etapeKey][0][typeKey];
           
            const typeSection = creerSectionType(etapeKey, typeKey);
            etapeSection.appendChild(typeSection);
            
            const conteneurOptions = creerConteneurOptions(etapeKey, typeKey);
            typeSection.appendChild(conteneurOptions);
            
            genererOptions(conteneurOptions, options, etapeKey, typeKey);
        }
        
        document.querySelector('form').appendChild(etapeSection);
    }
    
   
    calculerPrixTotal();
}

// Fonction pour créer une section d'étape
function creerSectionEtape(etapeKey) {
    const section = document.createElement('div');
    section.className = 'etape-section';
    section.id = `section-${etapeKey}`;
    
    const titre = document.createElement('div');
    titre.className = 'section-title';
    titre.textContent = ucFirst(etapeKey.replace('_', ' '));
    
    section.appendChild(titre);
    return section;
}

// Fonction pour créer une section de type d'option
function creerSectionType(etapeKey, typeKey) {
    const section = document.createElement('div');
    section.className = 'type-section';
    
    const titre = document.createElement('div');
    titre.className = 'section-title';
    titre.textContent = ucFirst(typeKey.replace('_', ' '));
    
    section.appendChild(titre);
    return section;
}

// Fonction pour créer un conteneur d'options
function creerConteneurOptions(etapeKey, typeKey) {
    const conteneur = document.createElement('div');
    conteneur.className = 'option-container';
    conteneur.id = `${etapeKey}_${typeKey}_container`;
    return conteneur;
}

// Fonction pour générer les options dans un conteneur
function genererOptions(conteneur, options, etapeKey, typeKey) {
    // Vider le conteneur actuel
    conteneur.innerHTML = '';
    
    // Créer un élément pour chaque option
    options.forEach(option => {
        const optionCard = document.createElement('div');
        optionCard.className = 'option-card';
        
        const optionName = option.option;
        const inputId = `${etapeKey}_${typeKey}_${optionName}`;
        
        // Vérifier si cette option a été sélectionnée précédemment
        const optionSelectionnee = trouverOptionSelectionnee(etapeKey, typeKey, optionName);
        const isSelected = optionSelectionnee !== null;
        const quantiteValue = isSelected ? optionSelectionnee.quantity : 1;
        
        // Création du HTML pour chaque option
        const label = document.createElement('label');
        label.htmlFor = inputId;
        
        const img = document.createElement('img');
        img.src = option.image;
        img.style.width = '50px';
        img.style.height = 'auto';
        
        label.appendChild(img);
        label.appendChild(document.createTextNode(` ${optionName} - ${option.Prix}`));
        
        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.id = inputId;
        radio.name = `${etapeKey}_${typeKey}`;
        radio.value = optionName;
        if (isSelected) {
            radio.checked = true;
        }
        
        // Ajouter un écouteur d'événement pour le bouton radio
        radio.addEventListener('change', function() {
            // Mettre à jour les options dépendantes
            mettreAJourOptionsDependantes(etapeKey, typeKey, this.value);
            
            // Activer le champ de quantité correspondant
            activerChampQuantite(etapeKey, typeKey, optionName);
            
            // Mettre à jour le prix total
            calculerPrixTotal();
            
            // Sauvegarder la sélection
            sauvegarderSelection(etapeKey, typeKey, optionName);
        });
        
        const inputQuantite = document.createElement('input');
        inputQuantite.type = 'number';
        inputQuantite.name = `${inputId}_nbr`;
        inputQuantite.value = quantiteValue;
        inputQuantite.min = '1';
        inputQuantite.placeholder = 'Nbr pers.';
        inputQuantite.disabled = !isSelected;
        
        // Ajouter un écouteur d'événement pour le champ de quantité
        inputQuantite.addEventListener('input', function() {
            // S'assurer que la quantité est au moins 1
            if (parseInt(this.value) < 1 || isNaN(parseInt(this.value))) {
                this.value = 1;
            }
            
            // Mettre à jour la quantité dans la sélection sauvegardée
            mettreAJourQuantite(etapeKey, typeKey, optionName, parseInt(this.value));
            
            // Mettre à jour le prix total
            calculerPrixTotal();
        });
        
        optionCard.appendChild(label);
        optionCard.appendChild(radio);
        optionCard.appendChild(inputQuantite);
        
        conteneur.appendChild(optionCard);
    });
}

// Fonction pour trouver une option sélectionnée
function trouverOptionSelectionnee(etapeKey, typeKey, optionName) {
    return optionsSelectionnees.find(option => 
        option.etape === etapeKey && 
        option.type === typeKey && 
        option.name === optionName
    ) || null;
}

// Fonction pour activer le champ de quantité d'une option sélectionnée
function activerChampQuantite(etapeKey, typeKey, optionName) {
    // Désactiver tous les champs de quantité pour ce type d'option
    document.querySelectorAll(`input[name^="${etapeKey}_${typeKey}_"][name$="_nbr"]`).forEach(input => {
        input.disabled = true;
    });
    
    // Activer uniquement le champ de quantité associé à l'option sélectionnée
    const inputId = `${etapeKey}_${typeKey}_${optionName}`;
    const quantityInput = document.querySelector(`input[name="${inputId}_nbr"]`);
    
    if (quantityInput) {
        quantityInput.disabled = false;
    }
}

// Fonction pour mettre à jour la quantité d'une option sélectionnée
function mettreAJourQuantite(etapeKey, typeKey, optionName, quantite) {
    // Trouver l'index de l'option sélectionnée
    const index = optionsSelectionnees.findIndex(option => 
        option.etape === etapeKey && 
        option.type === typeKey
    );
    
    if (index !== -1) {
        // Mettre à jour la quantité
        optionsSelectionnees[index].quantity = quantite;
        
        // Sauvegarder dans sessionStorage
        sessionStorage.setItem('selectedOptions', JSON.stringify(optionsSelectionnees));
    }
}

// Fonction pour mettre à jour les options dépendantes
function mettreAJourOptionsDependantes(etapeKey, typeKey, valeurSelectionnee) {
    // Vérifier s'il existe des dépendances pour cette option
    if (dependancesOptions[typeKey] && dependancesOptions[typeKey][valeurSelectionnee]) {
        
        // Pour chaque type dépendant
        for (const typeDependant in dependancesOptions[typeKey][valeurSelectionnee]) {
            const optionsDisponibles = dependancesOptions[typeKey][valeurSelectionnee][typeDependant];
            
            // Trouver l'étape qui contient ce type
            let etapeDependante = null;
            const voyage = document.querySelector('form').getAttribute('data-voyage');
            
            for (const etape in toutesOptions[voyage][0]) {
                if (toutesOptions[voyage][0][etape][0][typeDependant]) {
                    etapeDependante = etape;
                    break;
                }
            }
            
            if (etapeDependante) {
                // Filtrer les options selon les dépendances
                const optionsFiltrees = toutesOptions[voyage][0][etapeDependante][0][typeDependant].filter(
                    option => optionsDisponibles.includes(option.option)
                );
                
                // Mettre à jour l'affichage des options
                const conteneur = document.getElementById(`${etapeDependante}_${typeDependant}_container`);
                if (conteneur) {
                    genererOptions(conteneur, optionsFiltrees, etapeDependante, typeDependant);
                }
            }
        }
    }
}

// Fonction pour sauvegarder les sélections
function sauvegarderSelection(etapeKey, typeKey, valeur) {
    // Supprimer l'option existante pour cette catégorie
    optionsSelectionnees = optionsSelectionnees.filter(option => 
        !(option.etape === etapeKey && option.type === typeKey)
    );
    
    // Récupérer la quantité
    const inputId = `${etapeKey}_${typeKey}_${valeur}`;
    const quantityInput = document.querySelector(`input[name="${inputId}_nbr"]`);
    const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
    
    // Trouver le prix de l'option
    let price = "0";
    const voyage = document.querySelector('form').getAttribute('data-voyage');
    
    if (toutesOptions[voyage]) {
        const options = toutesOptions[voyage][0][etapeKey][0][typeKey];
        const option = options.find(opt => opt.option === valeur);
        if (option) {
            price = option.Prix;
        }
    }
    
    // Ajouter la nouvelle sélection
    optionsSelectionnees.push({
        etape: etapeKey,
        type: typeKey,
        name: valeur,
        price: price,
        quantity: quantity,
        // Ajouter également l'image de l'option si disponible
        image: trouverImageOption(voyage, etapeKey, typeKey, valeur)
    });
    
    // Sauvegarder dans sessionStorage
    sessionStorage.setItem('selectedOptions', JSON.stringify(optionsSelectionnees));
}

// Fonction pour trouver l'image d'une option
function trouverImageOption(voyageNom, etapeKey, typeKey, optionName) {
    if (toutesOptions[voyageNom]) {
        const options = toutesOptions[voyageNom][0][etapeKey][0][typeKey];
        const option = options.find(opt => opt.option === optionName);
        return option ? option.image : '';
    }
    return '';
}

// Fonction pour calculer le prix total
function calculerPrixTotal() {
    let total = 0;
    
    // Calculer le total à partir des options sélectionnées
    optionsSelectionnees.forEach(option => {
        const price = parseFloat(option.price.replace('$', ''));
        const quantity = parseInt(option.quantity) || 1;
        total += price * quantity;
    });
    
    // Mettre à jour l'affichage du prix total
    const totalElement = document.getElementById('total-price');
    if (totalElement) {
        totalElement.textContent = total.toFixed(2);
    }
}

// Fonction pour soumettre le formulaire et enregistrer les données
function soumettreDonnees() {
    // Si aucune option n'est sélectionnée, afficher un message
    if (optionsSelectionnees.length === 0) {
        afficherMessageErreur('Veuillez sélectionner au moins une option pour continuer.');
        return;
    }
    
    // Créer un formulaire caché pour envoyer les données
    const form = document.querySelector('form');
    
    // Ajouter un champ caché pour les options sélectionnées
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'selected_options_json';
    hiddenInput.value = JSON.stringify(optionsSelectionnees);
    form.appendChild(hiddenInput);
    
    // Soumettre le formulaire
    form.submit();
}

// Fonction pour afficher un message d'erreur
function afficherMessageErreur(message) {
    const errorContainer = document.createElement('div');
    errorContainer.className = 'error-message';
    errorContainer.textContent = message;
    
    document.querySelector('.container').prepend(errorContainer);
    
    // Supprimer le message après quelques secondes
    setTimeout(() => {
        errorContainer.remove();
    }, 5000);
}

// Fonction utilitaire pour mettre en majuscule la première lettre
function ucFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Initialiser le système au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    initialiserDonnees();
    
    // Remplacer l'action par défaut du bouton de soumission
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            soumettreDonnees();
        });
    }
});