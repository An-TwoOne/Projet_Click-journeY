<?php
session_start();

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['hebergement_futuriste'] = sanitize_input($_POST['hebergement_futuriste']);
    $_SESSION['restauration_futuriste'] = sanitize_input($_POST['restauration_futuriste']);
    $_SESSION['activites_futuriste'] = sanitize_input($_POST['activites_futuriste']);
    $_SESSION['transport_futuriste'] = sanitize_input($_POST['transport_futuriste']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voyage Futuriste</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        :root {
            --turquoise: #23f7dd;
            --noir: #000000;
            --or: #e2db8a;
            --blanc: #ffffff;
            --gris: #3f3d3d;
            --police: 'Montserrat', sans-serif;
            --taille-police: 18px;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--gris);
            font-family: var(--police);
            display: flex;
            justify-content: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            width: 90%;
            margin-top: 50px;
        }

        .voyage-card {
            width: 45%;
            background-color: var(--noir);
            padding: 20px;
            border-radius: 10px;
            margin-right: 5%;
        }

        .voyage-card h2 {
            color: var(--or);
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            color: var(--blanc);
        }

        select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            background-color: #e0e0e0;
        }

        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            background-color: var(--or);
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #f5ea79f8;
            box-shadow: 0px 0px 5px var(--or);
        }

        .image-preview-container {
            width: 45%;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .image-block {
            background-color: var(--noir);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            text-align: center;
        }

        .image-block h4 {
            color: var(--or);
            margin-bottom: 10px;
        }

        .image-dynamique {
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" class="voyage-card">
            <h2>Monde Futuriste</h2>

            <label for="hebergement_futuriste">Hébergement :</label>
            <select name="hebergement_futuriste" id="hebergement_futuriste">
                <option value="megabuilding" <?= ($_SESSION['hebergement_futuriste'] ?? '') == 'megabuilding' ? 'selected' : '' ?>>Megabuilding de Night City</option>
                <option value="hotel_holo" <?= ($_SESSION['hebergement_futuriste'] ?? '') == 'hotel_holo' ? 'selected' : '' ?>>Hôtel Holo</option>
                <option value="capsule_futuriste" <?= ($_SESSION['hebergement_futuriste'] ?? '') == 'capsule_futuriste' ? 'selected' : '' ?>>Capsule Futuriste</option>
            </select>

            <label for="restauration_futuriste">Restauration :</label>
            <select name="restauration_futuriste" id="restauration_futuriste">
                <option value="restaurant_hacker" <?= ($_SESSION['restauration_futuriste'] ?? '') == 'restaurant_hacker' ? 'selected' : '' ?>>Restaurant Hacker</option>
                <option value="bar_lumineux" <?= ($_SESSION['restauration_futuriste'] ?? '') == 'bar_lumineux' ? 'selected' : '' ?>>Bar Lumineux</option>
                <option value="repas_nano" <?= ($_SESSION['restauration_futuriste'] ?? '') == 'repas_nano' ? 'selected' : '' ?>>Repas Nano</option>
            </select>

            <label for="activites_futuriste">Activités :</label>
            <select name="activites_futuriste" id="activites_futuriste">
                <option value="hacker_space" <?= ($_SESSION['activites_futuriste'] ?? '') == 'hacker_space' ? 'selected' : '' ?>>Hackathon Spatial</option>
                <option value="chasse_bounty" <?= ($_SESSION['activites_futuriste'] ?? '') == 'chasse_bounty' ? 'selected' : '' ?>>Chasse à la prime</option>
                <option value="realite_augmente" <?= ($_SESSION['activites_futuriste'] ?? '') == 'realite_augmente' ? 'selected' : '' ?>>Réalité Augmentée</option>
            </select>

            <label for="transport_futuriste">Transport :</label>
            <select name="transport_futuriste" id="transport_futuriste">
                <option value="voiture_autonome" <?= ($_SESSION['transport_futuriste'] ?? '') == 'voiture_autonome' ? 'selected' : '' ?>>Voiture autonome</option>
                <option value="moto_hover" <?= ($_SESSION['transport_futuriste'] ?? '') == 'moto_hover' ? 'selected' : '' ?>>Moto Hover</option>
                <option value="drone_taxi" <?= ($_SESSION['transport_futuriste'] ?? '') == 'drone_taxi' ? 'selected' : '' ?>>Drone Taxi</option>
            </select>

            <input type="submit" value="Voir le récapitulatif">
        </form>

        <div class="image-preview-container">
            <?php
            $imgHebergement = "contenu_css/ville_futur.png";
            $imgRestauration = "contenu_css/ville_futur.png";
            $imgActivites = "contenu_css/ville_futur.png";
            $imgTransport = "contenu_css/ville_futur.png";

            if (!empty($_SESSION['hebergement_futuriste'])) {
                switch ($_SESSION['hebergement_futuriste']) {
                    case 'megabuilding': $imgHebergement = "images/Heberg1.png"; break;
                    case 'hotel_holo': $imgHebergement = "images/hotel_holo.png"; break;
                    case 'capsule_futuriste': $imgHebergement = "images/capsule.png"; break;
                }
            }

            if (!empty($_SESSION['restauration_futuriste'])) {
                switch ($_SESSION['restauration_futuriste']) {
                    case 'restaurant_hacker': $imgRestauration = "images/restaurant_hacker.png"; break;
                    case 'bar_lumineux': $imgRestauration = "images/bar_lumineux.png"; break;
                    case 'repas_nano': $imgRestauration = "images/repas_nano.png"; break;
                }
            }

            if (!empty($_SESSION['activites_futuriste'])) {
                switch ($_SESSION['activites_futuriste']) {
                    case 'hacker_space': $imgActivites = "images/hacker_space.png"; break;
                    case 'chasse_bounty': $imgActivites = "images/chasse_bounty.png"; break;
                    case 'realite_augmente': $imgActivites = "images/realite_augmente.png"; break;
                }
            }

            if (!empty($_SESSION['transport_futuriste'])) {
                switch ($_SESSION['transport_futuriste']) {
                    case 'voiture_autonome': $imgTransport = "images/voiture_autonome.png"; break;
                    case 'moto_hover': $imgTransport = "images/moto_hover.png"; break;
                    case 'drone_taxi': $imgTransport = "images/drone_taxi.png"; break;
                }
            }
            ?>

            <div class="image-block">
                <h4>Hébergement</h4>
                <img src="<?= $imgHebergement ?>" class="image-dynamique">
            </div>
            <div class="image-block">
                <h4>Restauration</h4>
                <img src="<?= $imgRestauration ?>" class="image-dynamique">
            </div>
            <div class="image-block">
                <h4>Activités</h4>
                <img src="<?= $imgActivites ?>" class="image-dynamique">
            </div>
            <div class="image-block">
                <h4>Transport</h4>
                <img src="<?= $imgTransport ?>" class="image-dynamique">
            </div>
        </div>
    </div>
</body>
</html>
