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
    <link rel="stylesheet" href="CSS/recapitulatif_voyage.css">
    <link rel = "stylesheet" type = "text/css" href = "CSS/header.css">
    <link href="contenu_css/icon.png" rel="icon">
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
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
                const quantite = parseInt(quantiteInput.value) || 1;
                if (quantite < 1) quantiteInput.value = 1; // Assurer un minimum de 1
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

        // Fonction pour enregistrer les quantités mises à jour
        function sauvegarderQuantites() {
            const updatedQuantities = [];
            let changes = false;
            
            // Récupérer toutes les quantités mises à jour
            document.querySelectorAll('.ligne-option').forEach((row, index) => {
                const quantiteInput = row.querySelector('.quantite');
                const newQuantity = parseInt(quantiteInput.value) || 1;
                
                // S'assurer que la quantité est au moins 1
                if (newQuantity < 1) {
                    quantiteInput.value = 1;
                    newQuantity = 1;
                }
                
                // Vérifier si la quantité a été modifiée
                const currentOptions = <?= json_encode($selected_options) ?>;
                const currentQuantity = parseInt(currentOptions[index].quantity);
                
                if (newQuantity !== currentQuantity) {
                    changes = true;
                    updatedQuantities.push({
                        index: index,
                        quantity: newQuantity
                    });
                }
            });
            
            // Si aucun changement, rediriger directement
            if (!changes) {
                window.location.href = 'voyage.php?nom=<?= urlencode($_SESSION['voyage']) ?>';
                return;
            }
            
            // Créer un formulaire pour envoyer les données
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'voyage.php?nom=<?= urlencode($_SESSION['voyage']) ?>';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'updated_quantities';
            input.value = JSON.stringify(updatedQuantities);
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        // Initialiser le calcul des prix au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            mettreAJourPrix();
        });
    </script>
</head>
<body>

    <?php include('header.php') ?>

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
                    <tr class="ligne-option">
                        <td><?= htmlspecialchars(ucwords(str_replace('_', ' ', $option['etape']))) ?></td>
                        <td><?= htmlspecialchars(ucwords(str_replace('_', ' ', $option['type']))) ?></td>
                        <td><?= htmlspecialchars($option['name']) ?></td>
                        <td class="prix"><?= htmlspecialchars($option['price']) ?></td>
                        <td>
                            <input type="number" class="quantite" value="<?= intval($option['quantity']) ?>" min="1" oninput="mettreAJourPrix()">
                        </td>
                        <td class="sous-total"><?= htmlspecialchars(floatval($option['price']) * intval($option['quantity'])) ?> $</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <h3>Prix total : <span id="prix-total"><?= $total_price ?> $</span></h3>
        </div>

        <div class="boutons">
            
            <form action="paiement.php" method="POST">
                <input type="hidden" name="voyage" value="<?= htmlspecialchars($_SESSION['voyage']) ?>">
                <input type="hidden" id="montant" name="montant" value="<?= $total_price ?>">
                <input type="submit" value="Passer au paiement" class="btn">
            </form>
            
            <button onclick="sauvegarderQuantites()" class="btn">🔧 Enregistrer et modifier la personnalisation</button>
        </div>
    </div>
</body>
</html>
