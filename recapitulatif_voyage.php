<?php
session_start();

    if (!isset($_SESSION['selected_options'])) {
        die('Aucune option sélectionnée.');
    }

    $selected_options = $_SESSION['selected_options'];
    $total_price = 0; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MultiversTrip Récapitulatif du Voyage</title>
    <link rel="stylesheet" href="recapitulatif_voyage.css">
    <link rel = "stylesheet" type = "text/css" href = "header.css">
    <link href="contenu_css/icon.png" rel="icon">
</head>
<body>

    <?php include('header.php') ?>

    <div class="contenu_recap">
        <h2>Récapitulatif de votre voyage</h2>
        <table>
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
                    
                    $price = (int) filter_var($option['price'], FILTER_SANITIZE_NUMBER_INT);
                    $quantity = (int) $option['quantity'];
                    $subtotal = $price * $quantity;

                    
                    $total_price += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($option['etape']) ?></td>
                        <td><?= htmlspecialchars($option['type']) ?></td>
                        <td><?= htmlspecialchars($option['name']) ?></td>
                        <td><?= htmlspecialchars($option['price']) ?></td>
                        <td><?= htmlspecialchars($option['quantity']) ?></td>
                        <td>
                            <input 
                                type="number" 
                                class="quantity-input" 
                                data-price="<?= $price ?>" 
                                data-name="<?= htmlspecialchars($option['name']) ?>" 
                                value="<?= $quantity ?>" 
                                min="1"
                            >
                        </td>
                        <td class="subtotal"><?= $subtotal ?> $</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <h3>Prix total : <?= $total_price ?> $</h3>
        </div>

        <div class="boutons">
            
            <a href="voyage.php?nom=<?= urlencode($_SESSION['voyage']) ?>" class="btn">🔧 Modifier le voyage</a>
           
            <a href="paiement.php?montant=<?= $total_price ?>" class="btn">💳 Passer au paiement</a>
        </div>
    </div>
    <script src="gestion_options_voyage.js"></script>
</body>
</html>
