<?php 
session_start();

if (!isset($_SESSION['selected_options'])) {
    die('Aucune option sélectionnée.');
}

$selected_options = $_SESSION['selected_options'];
$total_price = 0;
foreach ($selected_options as $option) {
    $total_price += $option['price'] * $option['quantity'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MultiversTrip Récapitulatif du Voyage</title>
    <link rel="stylesheet" href="recapitulatif_voyage.css">
    <link rel = "stylesheet" type = "text/css" href = "header.css">
    <link href="contenu_css/icon.png" rel="icon">
    <link id="theme" rel="stylesheet" href="commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
    <script>
        // Fonction JavaScript pour mettre à jour les prix dynamiquement
        function mettreAJourPrix() {
            let total = 0;

            // Parcourir toutes les lignes du tableau
            document.querySelectorAll('.ligne-option').forEach(row => {
                const prix = parseFloat(row.querySelector('.prix').textContent);
                const quantiteInput = row.querySelector('.quantite');
                const sousTotalCell = row.querySelector('.sous-total');

                // Récupérer la quantité et calculer le sous-total
                const quantite = parseInt(quantiteInput.value) || 0;
                const sousTotal = prix * quantite;

                // Mettre à jour le sous-total dans le tableau
                sousTotalCell.textContent = sousTotal.toFixed(2) + ' $';

                // Ajouter au total général
                total += sousTotal;
            });

            // Mettre à jour le prix total
            document.getElementById('prix-total').textContent = total.toFixed(2) + ' $';

            // Mettre à jour le champ caché pour le formulaire de paiement
            document.getElementById('montant').value = total.toFixed(2);
        }
    </script>
</head>
<body>

    <?php include('header.php') ?>

    <div class="contenu_recap">
        <h2>Récapitulatif de votre voyage</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($selected_options as $option): ?>
                    <tr class="ligne-option">
                        <td><?= htmlspecialchars($option['name']) ?></td>
                        <td class="prix"><?= htmlspecialchars($option['price']) ?></td>
                        <td>
                            <input type="number" class="quantite" value="<?= htmlspecialchars($option['quantity']) ?>" min="1" oninput="mettreAJourPrix()">
                        </td>
                        <td class="sous-total"><?= htmlspecialchars($option['price'] * $option['quantity']) ?> $</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <h3>Prix total : <span id="prix-total"><?= $total_price ?> $</span></h3>
        </div>

        <div class="boutons">
            <!-- Formulaire pour rediriger vers paiement.php -->
            <form action="paiement.php" method="POST">
                <input type="hidden" id="montant" name="montant" value="<?= $total_price ?>">
                <input type="submit" value="Passer au paiement" class="btn">
            </form>
            <!-- Bouton pour revenir à la page de personnalisation -->
            <a href="voyage.php?nom=<?= urlencode($_SESSION['voyage']) ?>" class="btn">🔧 Modifier la personnalisation</a>
        </div>
    </div>
</body>
</html>
