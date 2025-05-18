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
    'Date' => date('Y-m-d H:i:s') // Ajouter la date et l'heure de la transaction
);

$file = 'données_json/paiement.json';
if (file_exists($file)) {
    // Charger les données existantes
    $current_data = json_decode(file_get_contents($file), true);
    if (!$current_data) {
        $current_data = [];
    }
    $current_data[] = $transaction_data;
    file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT));
} else {
    // Créer un nouveau fichier avec la transaction
    $current_data = array($transaction_data);
    file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT));
}

// Traiter le statut du paiement
if ($status === 'accepted') {
    echo "<h1>Paiement accepté !</h1>";
    echo "<p>Merci pour votre paiement. Votre transaction a été validée.</p>";
    echo "<p>Transaction ID : " . htmlspecialchars($transaction) . "</p>";
    echo "<p>Montant : " . htmlspecialchars($montant) . " €</p>";
    echo "<a href='page_accueil.php'>Retour à l'accueil</a>";
} else {
    echo "<h1>Paiement refusé.</h1>";
    echo "<p>Votre paiement n'a pas pu être validé. Veuillez réessayer.</p>";
    echo "<a href='paiement.php'>Retour au paiement</a>";
}
?>