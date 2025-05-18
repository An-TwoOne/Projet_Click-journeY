<?php
session_start();

// Récupérer l'ID de l'utilisateur connecté
$user_id =  $_SESSION['Id']; 

// Fonction pour charger le panier de l'utilisateur
function chargerPanierUtilisateur($user_id) {
    $panier_file = 'données_json/Panier.json';
    
    if (!file_exists($panier_file)) {
        return [];
    }
    
    $paniers = json_decode(file_get_contents($panier_file), true);
    $panier_utilisateur = [];
    
    foreach ($paniers as $panier) {
        if ($panier['ID'] === $user_id) {
            $panier_utilisateur[] = $panier;
        }
    }
    
    return $panier_utilisateur;
}

// Charger les voyages de l'utilisateur
$voyages_utilisateur = chargerPanierUtilisateur($user_id);

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'voir_recap' && isset($_POST['voyage'])) {
        $voyage_nom = $_POST['voyage'];
        
        // Trouver les détails du voyage sélectionné
        foreach ($voyages_utilisateur as $voyage) {
            if ($voyage['Titre'] === $voyage_nom) {
                // Stocker les informations du voyage dans la session
                $_SESSION['voyage'] = $voyage_nom;
                $_SESSION['selected_options'] = $voyage['Specificité du voyage'];
                
                // Rediriger vers la page récapitulative
                header('Location: recapitulatif_voyage.php');
                exit();
            }
        }
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'supprimer' && isset($_POST['voyage'])) {
        $voyage_a_supprimer = $_POST['voyage'];
        $panier_file = 'données_json/Panier.json';
        
        if (file_exists($panier_file)) {
            $paniers = json_decode(file_get_contents($panier_file), true);
            $nouveaux_paniers = [];
            
            foreach ($paniers as $panier) {
                if (!($panier['ID'] === $user_id && $panier['Titre'] === $voyage_a_supprimer)) {
                    $nouveaux_paniers[] = $panier;
                }
            }
            
            file_put_contents($panier_file, json_encode($nouveaux_paniers, JSON_PRETTY_PRINT));
            
            // Recharger les voyages après suppression
            $voyages_utilisateur = chargerPanierUtilisateur($user_id);
        }
    }
}
function calculerPrixTotal($options) {
    $total = 0;
    foreach ($options as $option) {
        $total += floatval($option['price']) * intval($option['quantity']);
    }
    return $total;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip Panier</title>
    <link rel = "stylesheet" type = "text/css" href = "CSS/header.css">
    <link rel = "stylesheet" type = "text/css" href = "CSS/page_panier.css">
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
    <link href="contenu_css/icon.png" rel="icon">
    <link rel = "stylesheet" type = "text/css" href = "CSS/Panier.css">
</head>
<body>
    <?php include('header.php') ?>
<div class="panier-container">
        <div class="panier-header">
            <h1>Votre Panier MultiversTrip</h1>
            <span>👽 Voyages intergalactiques: <?php echo count($voyages_utilisateur); ?></span>
        </div>
        
        <?php if (empty($voyages_utilisateur)): ?>
            <div class="empty-panier">
                <h2>Votre panier est vide</h2>
                <p>Explorez nos différents mondes et univers pour planifier votre prochaine aventure!</p>
                <a href="page_destination.php" class="btn btn-primary btn-explore">Explorer les voyages</a>
            </div>
        <?php else: ?>
            <div class="voyage-cards">
                <?php foreach ($voyages_utilisateur as $voyage): ?>
                    <?php 
                    $nb_options = count($voyage['Specificité du voyage']);
                    $prix_total = calculerPrixTotal($voyage['Specificité du voyage']);
                    
                    // Trouver une image pour le voyage (utiliser la première option avec une image)
                    $image_voyage = "contenu_css/background_default.jpg"; // Image par défaut
                    foreach ($voyage['Specificité du voyage'] as $option) {
                        if (isset($option['image']) && !empty($option['image'])) {
                            $image_voyage = $option['image'];
                            break;
                        }
                    }

                    // Trouver les étapes uniques
                    $etapes = [];
                    foreach ($voyage['Specificité du voyage'] as $option) {
                        if (!in_array($option['etape'], $etapes)) {
                            $etapes[] = $option['etape'];
                        }
                    }
                    $nb_etapes = count($etapes);
                    ?>
                    
                    <div class="voyage-card">
                        <div class="voyage-image" style="background-image: url('<?php echo $image_voyage; ?>')">
                            <div class="voyage-banner"><?php echo $nb_etapes; ?> Étapes</div>
                        </div>
                        <div class="voyage-info">
                            <div class="voyage-title"><?php echo htmlspecialchars($voyage['Titre']); ?></div>
                            <div class="voyage-details">
                                <div class="voyage-detail">
                                    <span>Options:</span>
                                    <span><?php echo $nb_options; ?> activités/services</span>
                                </div>
                                <div class="voyage-detail">
                                    <span>Univers:</span>
                                    <span>Multivers #<?php echo substr(md5($voyage['Titre']), 0, 6); ?></span>
                                </div>
                            </div>
                            <div class="voyage-price"><?php echo number_format($prix_total, 2); ?> $</div>
                            <div class="voyage-actions">
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="voir_recap">
                                    <input type="hidden" name="voyage" value="<?php echo htmlspecialchars($voyage['Titre']); ?>">
                                    <button type="submit" class="btn btn-primary"><span class="icon-cart">🛒</span> Détails</button>
                                </form>
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="supprimer">
                                    <input type="hidden" name="voyage" value="<?php echo htmlspecialchars($voyage['Titre']); ?>">
                                    <button type="submit" class="btn btn-danger">🗑️</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>       
        <?php endif; ?>
    </div>
    
</body>
</html>