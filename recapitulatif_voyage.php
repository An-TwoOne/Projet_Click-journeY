<?php
session_start();

if (!isset($_SESSION['selected_options'])) {
    die('Aucune option sélectionnée.');
}

$selected_options = $_SESSION['selected_options'];
$total_price = 0; // Initialisation du prix total
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récapitulatif du Voyage</title>
    <link rel="stylesheet" href="style_personnalisation.css">
</head>
<body>
    <div class="contenu_recap">
        <h2>Récapitulatif de votre voyage</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Étape</th>
                    <th>Type</th>
                    <th>Option</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($selected_options as $option): ?>
                    <?php
                    // Calcul du sous-total pour chaque option
                    $price = (int) filter_var($option['price'], FILTER_SANITIZE_NUMBER_INT);
                    $quantity = (int) $option['quantity'];
                    $subtotal = $price * $quantity;

                    // Ajouter le sous-total au prix total
                    $total_price += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($option['etape']) ?></td>
                        <td><?= htmlspecialchars($option['type']) ?></td>
                        <td><?= htmlspecialchars($option['name']) ?></td>
                        <td><?= htmlspecialchars($option['price']) ?></td>
                        <td><?= htmlspecialchars($option['quantity']) ?></td>
                        <td><?= $subtotal ?> $</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <h3>Prix total : <?= $total_price ?> $</h3>
        </div>

        <div class="boutons">
            <!-- Bouton pour revenir à la page de personnalisation -->
            <a href="voyage.php?nom=<?= urlencode($_SESSION['voyage']) ?>" class="btn">🔧 Modifier le voyage</a>
            <!-- Bouton pour passer au paiement -->
            <a href="paiement.php?montant=<?= $total_price ?>" class="btn">💳 Passer au paiement</a>
        </div>
    </div>
</body>
</html>
