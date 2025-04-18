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
    <link rel="stylesheet" type="text/css" href="page_destination.css">
    <link rel = "stylesheet" type = "text/css" href = "header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <link href="contenu_css/icon.png" rel="icon">
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

        if ($match && $categorie_filtre): ?>
            <div class="contenu"> 
                <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($titre) ?>">
                <p><?= htmlspecialchars($titre) ?></p>
                <span><?= htmlspecialchars($description) ?></span>
                <div><a class="voir_plus" href="<?= htmlspecialchars($lien) ?>">Voir+</a> à partir de <?= htmlspecialchars($prix) ?></div>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>

    </div>

    <div id="filtres" class="filtres_conteneur">
        <form action =" https://www.cafe-it.fr/cytech/post.php" method="post">
            <h4 class="titre_filtres">Trouver votre voyage idéal</h4>
            <hr/>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" >

            <label for="duree">Durée du voyage:</label>
            <select id="duree" name="duree" >
                <option value="plusieurs_jours">plusieurs jours</option>
                <option value="quelque_heures">quelque heures</option>
                <option value="un_jour">un jour</option>
            </select>

            <label for="prix">Votre Budget (max):</label> 800€
            <input type="range" id="prix" name="prix" min="800" max="5000" value="2500" step="100"> 5000€

            <label for="experience">Expérience:</label>
            <input type="radio" id="experience" name="experience" value="solo" >Solo
            <input type="radio" id="experience" name="experience" value="en_groupe" >en Groupe

            <label for="periode_voyage">Période voyage:</label>
            <input type="checkbox" id ="periode_voyage" name="periode_voyage" value="Passé" >Passé
            <input type="checkbox" id ="periode_voyage" name="periode_voyage" value="Futuriste" >Futuriste
            <input type="checkbox" id ="periode_voyage" name="periode_voyage" value="Monde réel">Monde réel

            <label for="promotion">En promotion:</label>
            <input type="checkbox" id ="promotion" name="promotion" value="oui" >Oui

            <label for="equipement">Niveau d'équipement:</label>
            <input type="radio" id="equipement" name="equipement" value="standard" >Standard
            <input type="radio" id="equipement" name="equipement" value="Premium" >Premium
            <input type="radio" id="equipement" name="equipement" value="Luxe" >Luxe

            <label for="type_exp">Type d'expérience:</label>
            <input type="checkbox" id ="type_ex" name="type_ex" value="Aventure" >Aventure
            <input type="checkbox" id ="type_ex" name="type_ex" value="Détente" >Détente
            <input type="checkbox" id ="type_ex" name="type_ex" value="Sensationnel">Sensationnel

            <label for="univers">Univers:</label>
            <select id="univers" name="univers" >
                <option value="Film">Film</option>
                <option value="Mythologie">Mythologie</option>
                <option value="Jeux_Vidéo">Jeux Vidéo</option>
                <option value="Livres">Livres</option>
                <option value="Epoque_histo">Epoque historique</option>
            </select>

            <br></br>
            
            <input type="submit" value="Afficher Résultats">
            <a href="#" class="fermer-btn">Fermer</a>
            
        </form>
    </div>

    

</body>
</html>