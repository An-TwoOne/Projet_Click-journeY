<?php
session_start();

if (!isset($_SESSION['Id'])) {
    header('Location: page_connexion.php');
    exit();
}

require('getapikey.php'); 


$transaction_id = bin2hex(random_bytes(12));


$montant = $_GET['montant'] ?? '0.00';
$vendeur = 'MEF-2_H'; 
$retour_url = 'http://localhost/retour_paiement.php'; 


$api_key = getAPIKey($vendeur);


if (!preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
    die('Clé API invalide');
}


$control = md5($api_key . "#" . $transaction_id . "#" . $montant . "#" . $vendeur . "#" . $retour_url);


$absolute_path_paiements = "données_json/paiement.json";
$absolute_path_dataVoyages = "données_json/voyage.json";


$content_paiement = file_exists($absolute_path_paiements) ? file_get_contents($absolute_path_paiements) : '[]';
$content_voyage = file_exists($absolute_path_dataVoyages) ? file_get_contents($absolute_path_dataVoyages) : '[]';


$jsonArrayPaiement = json_decode($content_paiement, true);
$jsonArrayVoyage = json_decode($content_voyage, true);


$userData = [
    'status' => $_GET['status'] ?? null,
    'montant' => $montant,
    'transaction' => $transaction_id,
    'vendeur' => $vendeur,
    'control' => $control,
    'user' => $_SESSION['user'] ?? null
];


$jsonArrayPaiement[] = $userData;


if (isset($_SESSION['voyage_data'])) {
    $jsonArrayVoyage[] = $_SESSION['voyage_data'];
}


file_put_contents($absolute_path_paiements, json_encode($jsonArrayPaiement, JSON_PRETTY_PRINT));
file_put_contents($absolute_path_dataVoyages, json_encode($jsonArrayVoyage, JSON_PRETTY_PRINT));


unset($_SESSION['voyage_id']);
unset($_SESSION['voyage_data']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalisation du Paiement</title>
    
</head>
<body>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'accepted'): ?>
        <h1>Paiement accepté !</h1>
        <p>Merci pour votre paiement. Voici un récapitulatif de votre transaction :</p>
        <ul>
            <li><strong>Montant :</strong> <?= htmlspecialchars($montant) ?> €</li>
            <li><strong>Transaction ID :</strong> <?= htmlspecialchars($transaction_id) ?></li>
            <li><strong>Vendeur :</strong> <?= htmlspecialchars($vendeur) ?></li>
        </ul>
        <a href="page_accueil.php">Retour à l'accueil</a>
    <?php else: ?>
        <h1>Le paiement a échoué.</h1>
        <p>Nous sommes désolés pour ce désagrément. Veuillez réessayer le paiement.</p>
        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
            <input type="hidden" name="transaction" value="<?= htmlspecialchars($transaction_id) ?>">
            <input type="hidden" name="montant" value="<?= htmlspecialchars($montant) ?>">
            <input type="hidden" name="vendeur" value="<?= htmlspecialchars($vendeur) ?>">
            <input type="hidden" name="retour" value="<?= htmlspecialchars($retour_url) ?>">
            <input type="hidden" name="control" value="<?= htmlspecialchars($control) ?>">
            <button type="submit">Valider et payer</button>
        </form>
    <?php endif; ?>
</body>
</html>
