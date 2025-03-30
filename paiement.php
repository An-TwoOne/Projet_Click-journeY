<?php
    session_start();

   
    
    $absolute_path_paiements = "données_json/paiement.json";
    $absolute_path_dataVoyages = "données_json/voyage.json";

    
    $content_paiement = file_exists($absolute_path_paiements) ? file_get_contents($absolute_path_paiements) : '[]';
    $content_voyage = file_exists($absolute_path_dataVoyages) ? file_get_contents($absolute_path_dataVoyages) : '[]';

    
    $jsonArrayPaiement = json_decode($content_paiement, true);
    $jsonArrayVoyage = json_decode($content_voyage, true);


    $userData = [
        'status' => $_GET['status'] ?? null,
        'montant' => $_GET['montant'] ?? null,
        'transaction' => $_GET['transaction'] ?? null,
        'vendeur' => 'MEF-2_H', 
        'control' => $_GET['control'] ?? null,
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
    <link rel = "stylesheet" type = "text/css" href = "paiement.css">
    <link href="contenu_css/icon.png" rel="icon">
    <title>Finalisation du Paiement</title>
   
</head>
<body>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'accepted'): ?>
        <h1>Paiement accepté !</h1>
        <p>Merci pour votre paiement. Voici un récapitulatif de votre transaction :</p>
        <ul>
            <li><strong>Montant :</strong> <?= htmlspecialchars($_GET['montant'] ?? 'N/A') ?> €</li>
            <li><strong>Transaction ID :</strong> <?= htmlspecialchars($_GET['transaction'] ?? 'N/A') ?></li>
            <li><strong>Vendeur :</strong> <?= htmlspecialchars('MEF-2_H') ?></li>
        </ul>
        <a href="page_accueil.php">Retour à l'accueil</a>
    <?php else: ?>
        <h1>Le paiement a échoué.</h1>
        <p>Nous sommes désolés pour ce désagrément. Veuillez réessayer le paiement.</p>
        <a href="paiement.php">Retour au paiement</a>
    <?php endif; ?>
</body>
</html>
