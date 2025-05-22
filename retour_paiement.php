<?php
require('getapikey.php'); 

session_start();
$select_id = $_SESSION['Id'];

$transaction = $_GET['transaction'] ?? null;
$montant = $_GET['montant'] ?? null;
$vendeur = $_GET['vendeur'] ?? null;
$status = $_GET['status'] ?? null;
$control = $_GET['control'] ?? null;

if (!$transaction || !$montant || !$vendeur || !$status || !$control) {
    die('Données de retour manquantes');
}

$api_key = getAPIKey($vendeur);

if (!preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
    die('Clé API invalide');
}

$calculated_control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

if ($calculated_control !== $control) {
    die('Valeur de contrôle invalide');
}

$transaction_data = array(
    'ID' =>$select_id ,
    'Titre' => $_SESSION['voyage'] ?? 'Inconnu',
    'Identification transaction' => $transaction,
    'Paiement' => $montant,
    'Vendeur' => $vendeur,
    'Statut' => $status,
    'Date' => date('Y-m-d H:i:s')
);

$file = 'données_json/paiement.json';
if (file_exists($file)) {
    $current_data = json_decode(file_get_contents($file), true);
    if (!$current_data) {
        $current_data = [];
    }
    $current_data[] = $transaction_data;
    file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT));
} else {
    $current_data = array($transaction_data);
    file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT));
}

// Stocker les données nécessaires en session pour le retour vers paiement
$_SESSION['voyage_titre'] = $_SESSION['voyage'] ?? 'Inconnu';
$_SESSION['montant_paiement'] = $montant;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Retour Paiement</title>
    <link rel="stylesheet" href="CSS/retour_paiement.css">
</head>
<body>
    <div class="conteneur"> 
    <?php
        if ($status === 'accepted') {
            echo "<h1>Paiement accepté !</h1>";
            echo "<p>Merci pour votre paiement. Votre transaction a été validée.</p>";
            echo "<p>Transaction ID : " . htmlspecialchars($transaction) . "</p>";
            echo "<p>Montant : " . htmlspecialchars($montant) . " €</p>";
            echo "<a class='retour' href='page_accueil.php'>Retour à l'Accueil</a>";
        } else {
            echo "<h1>Paiement refusé.</h1>";
            echo "<p>Votre paiement n'a pas pu être validé. Veuillez réessayer.</p>";
            
            // Formulaire pour retourner vers paiement.php avec les bonnes données
            echo "<form action='paiement.php' method='POST' style='display: inline;'>";
            echo "<input type='hidden' name='voyage' value='" . htmlspecialchars($_SESSION['voyage_titre']) . "'>";
            echo "<input type='hidden' name='montant' value='" . htmlspecialchars($montant) . "'>";
            echo "<button type='submit' class='retour' style='background: none; border: none; color: inherit; text-decoration: underline; cursor: pointer; font-size: inherit;'>Retour au Paiement</button>";
            echo "</form>";
        }
    ?>
    </div>
</body>
</html>