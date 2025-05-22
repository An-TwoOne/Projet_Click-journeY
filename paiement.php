<?php 
session_start();
require('getapikey.php');

// Fonction pour générer un ID de transaction unique
function generateTransactionId() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = rand(10, 24);
    $transactionId = '';
    for ($i = 0; $i < $length; $i++) {
        $transactionId .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $transactionId;
}

// Vérifier les données - d'abord POST, puis session comme fallback
$nom_voyage = null;
$montant = null;

if (isset($_POST['voyage']) && isset($_POST['montant'])) {
    // Données venant du formulaire normal
    $nom_voyage = htmlspecialchars($_POST['voyage']);
    $montant = floatval($_POST['montant']);
} elseif (isset($_SESSION['voyage_titre']) && isset($_SESSION['montant_paiement'])) {
    // Données venant de la session (retour après paiement refusé)
    $nom_voyage = htmlspecialchars($_SESSION['voyage_titre']);
    $montant = floatval($_SESSION['montant_paiement']);
} else {
    die("Erreur : données manquantes.");
}

// Charger les données du fichier JSON
$file = 'données_json/paiement.json';
if (!file_exists($file)) {
    die("Erreur : le fichier récapitulatif n'existe pas.");
}

$data = json_decode(file_get_contents($file), true);
if (!$data) {
    die("Erreur : impossible de lire les données du fichier JSON.");
}

// Rechercher le voyage correspondant dans le fichier JSON
$voyage_trouve = null;
foreach ($data as $voyage) {
    if ($voyage['Titre'] === $nom_voyage) {
        $voyage_trouve = $voyage;
        break;
    }
}

if (!$voyage_trouve) {
    die("Erreur : le voyage sélectionné n'existe pas dans le fichier récapitulatif.");
}

// Récupérer les informations du voyage
$titre_voyage = $voyage_trouve['Titre'];
$vendeur = $voyage_trouve['Vendeur'];
$retour = "https://ominous-space-memory-pj7xg9775qgvh74j-3000.app.github.dev/retour_paiement.php";

// Générer un ID de transaction unique
$transaction = generateTransactionId();

// Obtenir la clé API
$api_key = getAPIKey($vendeur);

// Vérification de la clé API
if (preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
    $control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
} else {
    die("Clé API invalide.");
}

// Stocker le voyage en session pour le retour
$_SESSION['voyage'] = $nom_voyage;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip Récapitulatif du voyage paiement</title>
    <link rel="stylesheet" href="CSS/paiement.css">
    <link rel = "stylesheet" type = "text/css" href = "CSS/header.css">
    <link href="contenu_css/icon.png" rel="icon">
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
</head>
<body>

    <?php include('header.php') ?>
    <div class="conteneur">
        <h1 class="titre">Récapitulatif du voyage</h1>

        <p><strong>Titre du voyage :</strong> <?php echo htmlspecialchars($titre_voyage); ?></p>
        <p><strong>Montant total :</strong> <?php echo htmlspecialchars($montant); ?> EUR</p>

        <h2>Redirection vers CY Bank pour paiement</h2>
        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
            <!-- Informations de la transaction -->
            <input type="hidden" name="transaction" value="<?php echo htmlspecialchars($transaction); ?>">
            <input type="hidden" name="montant" value="<?php echo htmlspecialchars($montant); ?>">
            <input type="hidden" name="vendeur" value="<?php echo htmlspecialchars($vendeur); ?>">
            <input type="hidden" name="retour" value="<?php echo htmlspecialchars($retour); ?>">
            <input type="hidden" name="control" value="<?php echo htmlspecialchars($control); ?>">

        <button class="bouton" type="submit">Continuer vers le paiement sécurisé</button>
        </form>

        <p class="redirection">Si la redirection n'a pas lieu automatiquement, <a class="redirection_lien" href="https://www.plateforme-smc.fr/cybank/index.php">cliquez ici</a></p>
    </div> 
</body>
</html>