<?php
    session_start();

    if (!isset($_SESSION['Id'])) {
        header("Location: page_connexion.php");
        $_SESSION['message'] = "Connecter vous pour accéder aux voyages";
        exit();
    }
    $selected_id = $_SESSION['Id'];

// Fonction pour nettoyer les entrées
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Récupérer le nom du voyage depuis l'URL
$voyage_nom = isset($_GET['nom']) ? sanitize_input($_GET['nom']) : '';

// Charger les options du voyage uniquement pour vérifier si le voyage existe
$options_file = 'données_json/options.json';

if (!file_exists($options_file)) {
    die('Fichier options.json introuvable.');
}

$options = json_decode(file_get_contents($options_file), true);

// Vérifier si le voyage existe
if (empty($voyage_nom) || !isset($options[$voyage_nom])) {
    die('Voyage introuvable');
}

// Enregistrer le voyage sélectionné dans la session
$_SESSION['voyage'] = $voyage_nom;

// Fonction pour ajouter ou mettre à jour les données dans Panier.json
function ajouterOuMettreAJourPanier($voyage_nom, $selected_options, $selected_id) {
    $panier_file = 'données_json/Panier.json';

    // Charger le fichier Panier.json
    $panier = file_exists($panier_file) ? json_decode(file_get_contents($panier_file), true) : [];

    // Forcer l'utilisation de l'ID utilisateur "1" pour les tests
    $session_id = "1";

    // Vérifier si un panier existe déjà pour cet ID et le même titre
    $panier_existant = null;
    foreach ($panier as &$item) {
        if ($item['ID'] === $selected_id && $item['Titre'] === $voyage_nom) {
            $panier_existant = &$item;
            break;
        }
    }

    if ($panier_existant) {
        // Mettre à jour les données existantes
        $panier_existant['Specificité du voyage'] = $selected_options;
    } else {
        // Ajouter un nouveau panier
        $nouveau_panier = [
            "ID" =>$selected_id,
            "Titre" => $voyage_nom,
            "Specificité du voyage" => $selected_options
        ];
        $panier[] = $nouveau_panier;
    }

    // Sauvegarder les modifications dans Panier.json
    file_put_contents($panier_file, json_encode($panier, JSON_PRETTY_PRINT));
}

// Traitement du formulaire lors d'une soumission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['selected_options_json'])) {
        // Récupérer les options sélectionnées depuis le JSON
        $selected_options = json_decode($_POST['selected_options_json'], true);
        
        // Validation des données
        foreach ($selected_options as &$option) {
            $option['quantity'] = max(1, intval($option['quantity'])); // S'assurer que la quantité est au moins 1
            $option['price'] = str_replace('$', '', $option['price']); // Supprimer le symbole $
            $option['name'] = htmlspecialchars($option['name']);
            $option['etape'] = htmlspecialchars($option['etape']);
            $option['type'] = htmlspecialchars($option['type']);
        }
        unset($option);
        
        // Enregistrer les options sélectionnées dans la session
        $_SESSION['selected_options'] = $selected_options;
        
        // Ajouter ou mettre à jour les données dans Panier.json
        ajouterOuMettreAJourPanier($voyage_nom, $selected_options, $selected_id);
        
        // Rediriger vers la page récapitulative
        header('Location: recapitulatif_voyage.php');
        exit();
    }
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
    <script type='text/javascript' src="JS/options_dynamiques.js"></script>

</head>
<body>
    <?php include('header.php') ?>
     <div class="container">
        <h2>Personnalisez votre voyage: <?php echo $voyage_nom; ?></h2>

        <form action="voyage.php?nom=<?php echo urlencode($voyage_nom); ?>" method="post" data-voyage="<?php echo $voyage_nom; ?>">
            <!-- Les options seront générées dynamiquement par JavaScript -->
            
            <div class="total">
                <h3>Prix total : <span id="total-price">0</span> $</h3>
            </div>
            
            <button class="reservation" type="submit">Réservation</button>
    </form>
    </div>
</body>
</html>
