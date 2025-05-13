<?php
    session_start();
    $voyages = json_decode(file_get_contents('données_json/voyage.json'), true);
    $mot_cle = '';

    $filtre = 'tous';    

    if (isset($_GET['recherche_rapide'])) {
            $mot_cle = strtolower(trim($_GET['recherche_rapide']));
    }
    if (isset($_GET['filtre'])) {
        $filtre = strtolower($_GET['filtre']); 
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip Destinations</title>
    <link rel="stylesheet" type="text/css" href="CSS/page_destination.css">
    <link rel = "stylesheet" type = "text/css" href = "CSS/header.css">
    <link rel = "stylesheet" type = "text/css" href = "CSS/filtre_recherche.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
    <link href="contenu_css/icon.png" rel="icon">
    <script type='text/javascript' src="JS/filtre_recherche.js"></script>
</head>
<body>

    <?php include('header.php') ?>
    
    <div class="bloc_recherche">
        <form method="get">
            <div class="recherche">
                <span class="material-symbols-outlined">search</span>
                <input class="recherche_rapide" type="search" name="recherche_rapide" placeholder="Rechercher..." value="<?= htmlspecialchars($mot_cle) ?>">

            </div>
        </form>
    </div>


    <?php $active_class = ($filtre === 'tous') ? 'active' : ''; ?>
    <ul class="onglets" >
        <li class="<?= $filtre === 'tous' ? 'active' : '' ?>">
            <a href="?filtre=tous">
                <img src="contenu_css/menu_icon.png" alt="tous">
                Tous nos voyages
            </a>
        </li>
        <li class="<?= $filtre === 'tendance' ? 'active' : '' ?>">
            <a href="?filtre=tendance">
                <img src="contenu_css/tendance_icon.png" alt="tendance">
                Nos meilleures ventes
            </a>
        </li>
        <li class="<?= $filtre === 'notes' ? 'active' : '' ?>">
            <a href="?filtre=notes">
                <img src="contenu_css/etoile_icon.png" alt="etoile">
                Les mieux notés
            </a>
        </li>
        <li class="<?= $filtre === 'recent' ? 'active' : '' ?>">
            <a href="?filtre=recent">
                <img src="contenu_css/recent_icon.png" alt="horloge">
                Les plus récents
            </a>
        </li>
    </ul>
    
    
    

    <div id="conteneur">
        <?php foreach ($voyages as $voyage):
        $titre = $voyage['titre'];
        $description = $voyage['description'];
        $image = $voyage['image'];
        $lien = $voyage['lien'];
        $prix = $voyage['prix'];
        $tags = array_map('strtolower', $voyage['tags'] ?? []);
        $categories = array_map('strtolower', $voyage['categorie'] ?? []);

        $match = empty($mot_cle) || 
                strpos(strtolower($titre), $mot_cle) !== false || 
                strpos(strtolower($description), $mot_cle) !== false ||
                in_array($mot_cle, $tags);
        
        $categorie_filtre = $filtre === 'tous' || in_array($filtre, $categories);

        $duree = '';
        if (!empty($voyage['duree'])) {
            $duree = implode(',', $voyage['duree']);
        }

        $experience = '';
        if (!empty($voyage['experience'])) {
            $experience = implode(',', $voyage['experience']);
        }

        $periode = '';
        if (!empty($voyage['periode'])) {
            $periode = $voyage['periode'];
        }

        $promotion = '';
        if (!empty($voyage['promotion'])) {
            $promotion = $voyage['promotion'];
        }

        $equipement = '';
        if (!empty($voyage['equipement'])) {
            $equipement = implode(',', $voyage['equipement']);
        }

        $type = '';
        if (!empty($voyage['type_experience'])) {
            $type = implode(',', $voyage['type_experience']);
        }

        $univers = '';
        if (!empty($voyage['univers'])) {
            $univers = implode(',', $voyage['univers']);
        }

        if ($match && $categorie_filtre): ?>
            <a class="contenu" href="<?= htmlspecialchars($lien) ?>"
                    data-duree="<?= htmlspecialchars($duree) ?>"
                    data-prix="<?= htmlspecialchars($prix) ?>"
                    data-experience="<?= htmlspecialchars($experience) ?>"
                    data-periode="<?= htmlspecialchars($periode) ?>"
                    data-promotion="<?= htmlspecialchars($promotion) ?>"
                    data-equipement="<?= htmlspecialchars($equipement) ?>"
                    data-type="<?= htmlspecialchars($type) ?>"
                    data-univers="<?= htmlspecialchars($univers) ?>"> 
                    
                <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($titre) ?>">
                <p><?= htmlspecialchars($titre) ?></p>
                <span><?= htmlspecialchars($description) ?></span>
                <div>à partir de <?= htmlspecialchars($prix) ?></div>
            </a>
        <?php endif; ?>
        <?php endforeach; ?>

    </div>

    <?php include('filtre_recherche.php'); ?>

    

</body>
</html>