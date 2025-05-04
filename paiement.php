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

// Vérifier si les données nécessaires sont passées
if (!isset($_POST['voyage']) || !isset($_POST['montant'])) {
    die("Erreur : données manquantes.");
}

$nom_voyage = htmlspecialchars($_POST['voyage']); // Nom du voyage
$montant = floatval($_POST['montant']); // Prix total transmis depuis le récapitulatif

// Charger les données du fichier JSON
$file = 'paiement.json';
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
$date_debut = $voyage_trouve['date_depart'];
$date_fin = $voyage_trouve['date_retour'];
$vendeur = $voyage_trouve['vendeur'];
$retour = "http://localhost/projet_info/Projet_Click-journeY/retour_paiement.php";

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif du voyage et paiement</title>
</head>
<body>
    <h1>Récapitulatif du voyage</h1>

    <p><strong>Titre du voyage :</strong> <?php echo htmlspecialchars($titre_voyage); ?></p>
    <p><strong>Date de début :</strong> <?php echo htmlspecialchars($date_debut); ?></p>
    <p><strong>Date de fin :</strong> <?php echo htmlspecialchars($date_fin); ?></p>
    <p><strong>Montant total :</strong> <?php echo htmlspecialchars($montant); ?> EUR</p>

    <h2>Redirection vers CY Bank pour paiement</h2>
    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <!-- Informations de la transaction -->
        <input type="hidden" name="transaction" value="<?php echo htmlspecialchars($transaction); ?>">
        <input type="hidden" name="montant" value="<?php echo htmlspecialchars($montant); ?>">
        <input type="hidden" name="vendeur" value="<?php echo htmlspecialchars($vendeur); ?>">
        <input type="hidden" name="retour" value="<?php echo htmlspecialchars($retour); ?>">
        <input type="hidden" name="control" value="<?php echo htmlspecialchars($control); ?>">

        <button type="submit">Continuer vers le paiement sécurisé</button>
    </form>

    <p>Si la redirection n'a pas lieu automatiquement, <a href="https://www.plateforme-smc.fr/cybank/index.php">cliquez ici</a>.</p>
</body>
</html>
