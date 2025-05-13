<?php
    session_start();

    if (!isset($_SESSION['Id'])) {
        header("Location: page_connexion.php");
        $_SESSION['message'] = "Connecter vous pour accéder aux voyages";
        exit();
    }


   
function mettreAJourQuantite($voyage_nom, $option_name, $nouvelle_quantite) {
    $options_file = 'données_json/options.json';

    // Vérifier si le fichier JSON existe
    if (!file_exists($options_file)) {
        die('Fichier options.json introuvable.');
    }

    // Charger le contenu du fichier JSON
    $options = json_decode(file_get_contents($options_file), true);

    // Vérifier si le voyage existe dans le fichier JSON
    if (!isset($options[$voyage_nom])) {
        die("Le voyage '$voyage_nom' n'existe pas dans le fichier JSON.");
    }

    // Parcourir les étapes et types pour trouver l'option correspondante
    $option_trouvee = false;
    foreach ($options[$voyage_nom][0] as $etape_key => $etape_data) {
        foreach ($etape_data[0] as $category_key => $options_array) {
            foreach ($options_array as $option_index => $option_data) {
                if ($option_data['option'] === $option_name) {
                    // Mettre à jour la quantité
                    $options[$voyage_nom][0][$etape_key][0][$category_key][$option_index]['quantity'] = (string)$nouvelle_quantite;
                    $option_trouvee = true;
                    break 3; // Sortir des boucles imbriquées
                }
            }
        }
    }

    // Si l'option n'a pas été trouvée, afficher un message d'erreur
    if (!$option_trouvee) {
        // Journaliser l'erreur plutôt que d'arrêter l'exécution
        error_log("L'option '$option_name' n'a pas été trouvée dans le voyage '$voyage_nom'.");
        return false;
    }

    // Sauvegarder les modifications dans le fichier JSON
    if (file_put_contents($options_file, json_encode($options, JSON_PRETTY_PRINT)) === false) {
        die('Erreur lors de la sauvegarde des modifications dans le fichier JSON.');
    }

    return true;
}

// Vérifier si des options mises à jour sont reçues
if (isset($_POST['updated_quantities'])) {
    $updated_quantities = json_decode($_POST['updated_quantities'], true);

    if (is_array($updated_quantities)) { // Retiré !empty() pour permettre aussi un tableau vide
        // Vérifier si le voyage et les options sélectionnées existent en session
        if (isset($_SESSION['voyage']) && isset($_SESSION['selected_options'])) {
            $voyage_nom = $_SESSION['voyage'];
            $update_success = true;
            
            // Si le tableau est vide mais que nous avons des options en session, utiliser les quantités existantes
            if (empty($updated_quantities) && !empty($_SESSION['selected_options'])) {
                // Créer une liste de toutes les options avec leurs quantités actuelles
                foreach ($_SESSION['selected_options'] as $index => $option) {
                    $updated_quantities[] = [
                        'index' => $index,
                        'quantity' => $option['quantity']
                    ];
                }
            }
            
            // Traiter chaque quantité mise à jour
            foreach ($updated_quantities as $updated) {
                $index = $updated['index'];
                $quantity = $updated['quantity'];
                
                // Vérifier si l'index existe dans les options sélectionnées
                if (isset($_SESSION['selected_options'][$index])) {
                    $option_name = $_SESSION['selected_options'][$index]['name'];
                    
                    // Mettre à jour la quantité dans le fichier JSON
                    $json_update = mettreAJourQuantite($voyage_nom, $option_name, $quantity);
                    if (!$json_update) {
                        $update_success = false;
                        // Enregistrer l'erreur mais continuer avec les autres mises à jour
                        error_log("Échec de mise à jour de la quantité pour l'option: $option_name");
                    }
                    
                    // Mettre à jour la quantité dans la session (toujours faire cette mise à jour)
                    $_SESSION['selected_options'][$index]['quantity'] = $quantity;
                }
            }
            
            // Message de débogage optionnel
            if (!$update_success) {
                error_log("Certaines quantités n'ont pas pu être mises à jour dans le fichier JSON.");
            }
        }
    }

    // Rediriger vers la page récapitulative
    header('Location: recapitulatif_voyage.php');
    exit();
}
// Fonction pour nettoyer les entrées
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Charger les options du voyage
$options_file = 'données_json/options.json';
$options = json_decode(file_get_contents($options_file), true);

// Récupérer le nom du voyage depuis l'URL
$voyage_nom = isset($_GET['nom']) ? sanitize_input($_GET['nom']) : '';

// Vérifier si le voyage existe
if (empty($voyage_nom) || !isset($options[$voyage_nom])) {
    die('Voyage introuvable');
}

// Enregistrer le voyage sélectionné dans la session
$_SESSION['voyage'] = $voyage_nom;

// Enregistrer les sélections des options dans la session
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['updated_quantities'])) {
    $selected_options = []; // Tableau pour stocker les options choisies

    foreach ($options[$voyage_nom][0] as $etape_key => $etape) {
        foreach ($etape[0] as $type_key => $options_array) {
            // Vérifier si une option a été sélectionnée pour ce type
            if (isset($_POST["{$etape_key}_{$type_key}"])) {
                $selected_option_name = $_POST["{$etape_key}_{$type_key}"];
                
                // Récupérer la quantité saisie (par défaut 1 si non fournie)
                $quantity_key = "{$etape_key}_{$type_key}_{$selected_option_name}_nbr";
                $quantity = isset($_POST[$quantity_key]) && is_numeric($_POST[$quantity_key]) 
                    ? max(1, intval($_POST[$quantity_key])) 
                    : 1;
                
                foreach ($options_array as $option) {
                    if ($option['option'] === $selected_option_name) {
                        // Ajouter les informations de l'option choisie au tableau
                        $selected_options[] = [
                            'etape' => $etape_key,
                            'type' => $type_key,
                            'name' => $option['option'],
                            'price' => $option['Prix'],
                            'quantity' => $quantity,
                            'image' => $option['image'] // Ajouter l'image de l'option
                        ];
                        break;
                    }
                }
            }
        }
    }

    // Validation des données
    foreach ($selected_options as &$option) {
        $option['quantity'] = max(1, intval($option['quantity'])); // S'assurer que la quantité est au moins 1
        $option['price'] = floatval(str_replace('$', '', $option['price'])); // Supprimer le symbole $ et convertir en float
        $option['name'] = htmlspecialchars($option['name']);
        $option['etape'] = htmlspecialchars($option['etape']);
        $option['type'] = htmlspecialchars($option['type']);
    }
    unset($option);

    // Enregistrer les options sélectionnées dans la session
    $_SESSION['selected_options'] = $selected_options;

    // Rediriger vers la page récapitulative
    header('Location: recapitulatif_voyage.php');
    exit();
}

// Récupérer les options transmises via l'URL
$selected_options = [];
if (isset($_GET['options'])) {
    $selected_options = json_decode($_GET['options'], true);
}

// Si aucune option n'est transmise, utilisez celles de la session
if (empty($selected_options) && isset($_SESSION['selected_options'])) {
    $selected_options = $_SESSION['selected_options'];
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MultiversTrip Personnalisation du Voyage</title>
    <link rel="stylesheet" href="CSS/voyage.css">
    <link rel = "stylesheet" type = "text/css" href = "CSS/header.css">
    <link href="contenu_css/icon.png" rel="icon">
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
    <script>
    // Fonction pour calculer et afficher le prix total en temps réel
    function calculerPrixTotal() {
        let total = 0;
        const options = document.querySelectorAll('input[type="radio"]:checked');
        
        options.forEach(option => {
            const optionId = option.id;
            const quantityInput = document.querySelector(`input[name="${optionId}_nbr"]`);
            
            if (quantityInput) {
                const quantity = parseInt(quantityInput.value) || 1;
                // S'assurer que la quantité est au moins 1
                if (quantity < 1) {
                    quantityInput.value = 1;
                }
                
                const priceText = option.parentNode.textContent.match(/\d+\$/) ? 
                                  option.parentNode.textContent.match(/\d+\$/)[0] : '0$';
                const price = parseFloat(priceText.replace('$', ''));
                
                total += price * quantity;
            }
        });
        
        document.getElementById('total-price').textContent = total.toFixed(2);
    }

    // Fonction pour enregistrer les quantités mises à jour
    function sauvegarderQuantites() {
        const updatedQuantities = [];
        const newSelections = {};
        let changes = false;
        let hasNewSelections = false;
        
        // Récupérer les sélections actuelles
        const selectedOptions = <?= json_encode($selected_options) ?>;
        const mappedOptions = {};
        
        // Créer un mapping des options existantes pour recherche rapide
        selectedOptions.forEach((option, idx) => {
            const key = `${option.etape}_${option.type}`;
            mappedOptions[key] = {
                index: idx,
                name: option.name,
                quantity: option.quantity
            };
        });
        
        // Récupérer tous les radio buttons sélectionnés
        document.querySelectorAll('input[type="radio"]:checked').forEach((radio) => {
            const optionId = radio.id;
            const optionName = radio.value;
            const etape = optionId.split('_')[0];
            const type = optionId.split('_')[1];
            const categoryKey = `${etape}_${type}`;
            const quantityInput = document.querySelector(`input[name="${optionId}_nbr"]`);
            
            if (quantityInput) {
                const newQuantity = parseInt(quantityInput.value) || 1;
                
                // S'assurer que la quantité est au moins 1
                if (newQuantity < 1) {
                    quantityInput.value = 1;
                }
                
                // Vérifier si une option a changé dans cette catégorie
                if (!mappedOptions[categoryKey] || mappedOptions[categoryKey].name !== optionName) {
                    // Nouvelle sélection ou changement d'option
                    hasNewSelections = true;
                    
                    // Stocker les informations de la nouvelle sélection
                    newSelections[categoryKey] = {
                        etape: etape,
                        type: type,
                        name: optionName,
                        quantity: newQuantity
                    };
                }
                else {
                    // L'option existe déjà, vérifier si la quantité a changé
                    const existingIdx = mappedOptions[categoryKey].index;
                    const existingQty = mappedOptions[categoryKey].quantity;
                    
                    if (parseInt(existingQty) !== newQuantity) {
                        changes = true;
                    }
                    
                    // Ajouter à la liste des quantités à mettre à jour
                    updatedQuantities.push({
                        index: existingIdx,
                        quantity: newQuantity
                    });
                }
            }
        });
        
        // Si nouvelles sélections, soumettre le formulaire normalement pour tout recréer
        if (hasNewSelections) {
            // Créer des champs cachés pour conserver les quantités des options existantes
            const form = document.querySelector('form');
            
            // Soumettre directement le formulaire pour que PHP traite les nouvelles sélections
            form.submit();
            return;
        }
        
        // Si aucun changement de quantité et pas de nouvelles sélections
        if (!changes && updatedQuantities.length === 0) {
            document.querySelector('form').submit();
            return;
        }
        
        // Créer un formulaire pour envoyer les données mises à jour
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'voyage.php?nom=<?= urlencode($voyage_nom) ?>';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'updated_quantities';
        input.value = JSON.stringify(updatedQuantities);
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }

    // Ajouter des écouteurs d'événements une fois que le DOM est chargé
    document.addEventListener('DOMContentLoaded', function() {
        // Calculer le prix initial
        calculerPrixTotal();
        
        // Ajouter des écouteurs pour les changements de radio et de quantité
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', calculerPrixTotal);
        });
        
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function() {
                // S'assurer que la quantité est au moins 1
                if (parseInt(this.value) < 1 || isNaN(parseInt(this.value))) {
                    this.value = 1;
                }
                calculerPrixTotal();
            });
        });

        // Pour chaque radio button, associer le champ de quantité
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Désactiver tous les champs de quantité dans cette catégorie
                const etape_type = this.name;
                document.querySelectorAll(`input[name$="_nbr"]`).forEach(qtyInput => {
                    if (qtyInput.name.startsWith(etape_type.split('_')[0]) && 
                        qtyInput.name.includes(etape_type.split('_')[1])) {
                        qtyInput.disabled = true;
                    }
                });
                
                // Activer uniquement le champ de quantité associé à l'option sélectionnée
                const quantityInput = document.querySelector(`input[name="${this.id}_nbr"]`);
                if (quantityInput) {
                    quantityInput.disabled = false;
                }
            });
        });

        // Initialiser les états des champs de quantité
        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
            const quantityInput = document.querySelector(`input[name="${radio.id}_nbr"]`);
            if (quantityInput) {
                quantityInput.disabled = false;
            }
        });
        
        // Remplacer le comportement par défaut du bouton de soumission
        document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
            e.preventDefault();
            sauvegarderQuantites();
        });
    });
    </script>
</head>
<body>
    <?php include('header.php') ?>
    <div class="container">
    <h2>Personnalisez votre voyage: <?php echo $voyage_nom; ?></h2>

    <form action="voyage.php?nom=<?php echo urlencode($voyage_nom); ?>" method="post">
    <?php
        // Générer dynamiquement les étapes du voyage
        foreach ($options[$voyage_nom][0] as $etape_key => $etape) {
            echo "<div class='section-title'>" . ucwords(str_replace('_', ' ', $etape_key)) . "</div>";
            foreach ($etape[0] as $type_key => $options_array) {
                echo "<div class='section-title'>" . ucwords(str_replace('_', ' ', $type_key)) . "</div>";
                echo "<div class='option-container'>";
                foreach ($options_array as $option) {
                    $option_name = $option['option'];
                    $option_price = $option['Prix'];

                    // Vérifier si cette option a été sélectionnée précédemment
                    $is_selected = false;
                    $quantity_value = 1; // Valeur par défaut
                    foreach ($selected_options as $selected_option) {
                        if ($selected_option['name'] === $option_name) {
                            $is_selected = true;
                            // Assurer que la quantité est un nombre entier
                            $quantity_value = intval($selected_option['quantity']);
                            if ($quantity_value < 1) $quantity_value = 1;
                            break;
                        }
                    }
                    $input_name = "{$etape_key}_{$type_key}_{$option_name}_nbr";
                    $input_id = "{$etape_key}_{$type_key}_{$option_name}";
                    $disabled = $is_selected ? '' : 'disabled';

                    echo "<div class='option-card'>
                            <label for='{$input_id}'>
                                {$option_name} - {$option_price}
                            </label>
                            <input type='radio' id='{$input_id}' name='{$etape_key}_{$type_key}' value='{$option_name}' " . ($is_selected ? 'checked' : '') . ">
                            <input type='number' name='{$input_name}' value='{$quantity_value}' min='1' placeholder='Nbr pers.' {$disabled} oninput='calculerPrixTotal()'>
                          </div>";
                }
                echo "</div>";
            }
        }
        ?>
        <div class="total">
        <h3>Prix total : <span id="total-price">0</span> $</h3>
    </div>
        <button class="reservation" type="submit">Réservation</button>
    </form>
    </div>
</body>
</html>
