<?php
    session_start();

    if (!isset($_SESSION['Id'])) {
        header("Location: page_connexion.php");
        $_SESSION['message'] = "Connecter vous pour accéder aux voyages";
        exit();
    }


    function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


    $options_file = 'données_json/options.json';
    $options = json_decode(file_get_contents($options_file), true);


    $voyage_nom = isset($_GET['nom']) ? sanitize_input($_GET['nom']) : '';


    if (empty($voyage_nom) || !isset($options[$voyage_nom])) {
        die('Voyage introuvable');
    }


    $_SESSION['voyage'] = $voyage_nom;


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $selected_options = []; 

        foreach ($options[$voyage_nom][0] as $etape_key => $etape) {
            foreach ($etape[0] as $type_key => $options_array) {
            
                if (isset($_POST["{$etape_key}_{$type_key}"])) {
                    $selected_option_name = $_POST["{$etape_key}_{$type_key}"];
                    foreach ($options_array as $option) {
                        if ($option['option'] === $selected_option_name) {
                            
                            $quantity = isset($_POST["{$etape_key}_{$type_key}_{$selected_option_name}_nbr"]) 
                                ? (int)$_POST["{$etape_key}_{$type_key}_{$selected_option_name}_nbr"] 
                                : 1;

                            
                            $selected_options[] = [
                                'etape' => $etape_key,
                                'type' => $type_key,
                                'name' => $option['option'],
                                'price' => $option['Prix'],
                                'quantity' => $quantity
                            ];
                            break;
                        }
                    }
                }
            }
        }

    
    $_SESSION['selected_options'] = $selected_options;

    
    header('Location: recapitulatif_voyage.php');
    exit();
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
</head>
<body>
    <?php include('header.php') ?>
    <div class="container">
    <h2>Personnalisez votre voyage: <?php echo $voyage_nom; ?></h2>

    <form action="voyage.php?nom=<?php echo urlencode($voyage_nom); ?>" method="post">
        <?php
        
        foreach ($options[$voyage_nom][0] as $etape_key => $etape) {
            echo "<div class='section-title'>" . ucwords(str_replace('_', ' ', $etape_key)) . "</div>";
            foreach ($etape[0] as $type_key => $options_array) {
                echo "<div class='section-title'>" . ucwords(str_replace('_', ' ', $type_key)) . "</div>";
                echo "<div class='option-container'>";
                foreach ($options_array as $option) {
                    $option_name = $option['option'];
                    $option_image = $option['image'];
                    $option_price = $option['Prix'];
                    echo "<div class='option-card'>
                            <label for='{$etape_key}_{$type_key}_{$option_name}'>{$option_name} - {$option_price}</label>
                            <input type='radio' name='{$etape_key}_{$type_key}' value='{$option_name}'>
                            <input type='number' name='{$etape_key}_{$type_key}_{$option_name}_nbr' value='1' min='1' placeholder='Nbr pers.'>
                          </div>";
                }
                echo "</div>";
            }
        }
        ?>

        <button  class ="reservation" type="submit">Réservation</button>
    </form>
    </div>
</body>
</html>
