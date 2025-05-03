<?php
session_start();

// Vérifier si les informations nécessaires sont disponibles
if (!isset($_SESSION['voyage']) || !isset($_POST['montant'])) {
    die('Informations de paiement manquantes.');
}

$voyage_nom = htmlspecialchars($_SESSION['voyage']);
$montant = number_format((float) $_POST['montant'], 2, '.', ''); // Formatage du montant
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Paiement</title>
</head>
<body>
    <h1>Récapitulatif du voyage</h1>
    <p><strong>Titre du voyage:</strong> <span id="title"><?= $voyage_nom ?></span></p>
    <p><strong>Dates:</strong> <span id="dates">Du 01 Juin 2025 au 10 Juin 2025</span></p> <!-- Exemple statique -->

    <h2>Informations de paiement</h2>
    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="1234567890ABCDE"> <!-- Exemple statique -->
        <input type="hidden" name="montant" value="<?= $montant ?>">
        <input type="hidden" name="vendeur" value="MEF-2_H"> <!-- Exemple statique -->
        <input type="hidden" name="retour" value="http://localhost/retour_paiement.php?session=s">

        <label for="card_number">Numéro de carte:</label>
        <input type="text" name="card_number" id="card_number" maxlength="16" pattern="\d{16}" placeholder="1234567812345678" required>

        <label for="cardholder_name">Nom du titulaire de la carte:</label>
        <input type="text" name="cardholder_name" id="cardholder_name" required>

        <label for="expiry_date">Date d'expiration (MM/AAAA):</label>
        <input type="text" name="expiry_date" id="expiry_date" pattern="\d{2}/\d{4}" placeholder="MM/AAAA" required>

        <label for="cvv">Code de sécurité (CVV):</label>
        <input type="text" name="cvv" id="cvv" maxlength="3" pattern="\d{3}" placeholder="123" required>

        <input type="submit" value="Valider et payer">
    </form>
</body>
</html>
