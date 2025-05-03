<?php
    session_start();

    if (!isset($_SESSION['Id'])) {
        header("Location: page_connexion.php");
        $_SESSION['message'] = "Connecter vous pour accéder aux voyages";
        exit();
    }


   
function mettreAJourQuantite($voyage_nom, $option_name, $nouvelle_quantite) {
    $options_file = 'options.json';

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
    foreach ($options[$voyage_nom] as $step_key => $step_value) {
        foreach ($step_value[0] as $category_key => $category_value) {
            foreach ($category_value as $option_key => $option_value) {
                if ($option_value['option'] === $option_name) {
                    // Mettre à jour la quantité
                    $options[$voyage_nom][$step_key][0][$category_key][$option_key]['quantity'] = $nouvelle_quantite;
                    $option_trouvee = true;
                    break 3; // Sortir des boucles imbriquées
                }
            }
        }
    }

    // Si l'option n'a pas été trouvée, afficher un message d'erreur
    if (!$option_trouvee) {
        die("L'option '$option_name' n'a pas été trouvée dans le voyage '$voyage_nom'.");
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

    foreach ($updated_quantities as $updated) {
        $index = $updated['index'];
        $quantity = $updated['quantity'];
        $voyage_nom = $_SESSION['voyage'];
        $option_name = $_SESSION['selected_options'][$index]['name'];

        // Appeler la fonction pour mettre à jour la quantité
        mettreAJourQuantite($voyage_nom, $option_name, $quantity);
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
$options_file = 'options.json';
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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_options = []; // Tableau pour stocker les options choisies

    foreach ($options[$voyage_nom][0] as $etape_key => $etape) {
        foreach ($etape[0] as $type_key => $options_array) {
            // Vérifier si une option a été sélectionnée pour ce type
            if (isset($_POST["{$etape_key}_{$type_key}"])) {
                $selected_option_name = $_POST["{$etape_key}_{$type_key}"];
                foreach ($options_array as $option) {
                    if ($option['option'] === $selected_option_name) {
                        // Récupérer la quantité saisie par l'utilisateur pour l'option sélectionnée
                        $quantity = isset($_POST["{$etape_key}_{$type_key}_{$selected_option_name}_nbr"]) 
                            ? (int)$_POST["{$etape_key}_{$type_key}_{$selected_option_name}_nbr"] 
                            : 1;

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
        $option['quantity'] = intval($option['quantity']);
        $option['price'] = floatval($option['price']);
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
    <link rel="stylesheet" href="voyage.css">
    <link rel = "stylesheet" type = "text/css" href = "header.css">
    <link href="contenu_css/icon.png" rel="icon">
    <link id="theme" rel="stylesheet" href="commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
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
                    $quantity_value = 1; // Valeur par défaut
                    foreach ($selected_options as $selected_option) {
                        if ($selected_option['name'] === $option_name) {
                            $quantity_value = $selected_option['quantity'];
                            break;
                        }
                    }

                    echo "<div class='option-card'>
                            <label for='{$etape_key}_{$type_key}_{$option_name}'>
                                <img src='{$option['image']}' alt='{$option_name}' style='width: 50px; height: auto;'>
                                {$option_name} - {$option_price}
                            </label>
                            <input type='radio' name='{$etape_key}_{$type_key}' value='{$option_name}' " .(isset($selected_option) && $selected_option['name'] === $option_name ? 'checked' : '') .">
                            <input type='number' name='{$etape_key}_{$type_key}_{$option_name}_nbr' value='{$quantity_value}' min='1' placeholder='Nbr pers.'>
                          </div>";
                }
                echo "</div>";
            }
        }
        ?>
        <div class="total">
        <h3>Prix total : <span id="total-price">0</span> $</h3>
    </div>
        <button type="submit">Réservation</button>
    </form>
    </div>
</body>
</html>
