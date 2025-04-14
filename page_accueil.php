<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip</title>
    <link rel = "stylesheet" type = "text/css" href = "page_accueil.css">
    <link rel = "stylesheet" type = "text/css" href = "header.css">
    <link href="contenu_css/icon.png" rel="icon">
</head>

<body>

    <?php include('header.php') ?>

    <div class="bloc">
        <video autoplay="true" muted="" loop ="infinite"  src="contenu_css/main_video.mp4" type = "videpo/mp4" > </video>
        <h1>Voyager sans limite !</h1>
    </div>
    <div class = "presentation">
        <a href="page_destination.php" class="destinations"> Découvrir les destinations <img src="contenu_css/flèche.png" alt="flèche"></a>
        <p>
            Plongez dans une autre dimension et explorer divers univers grâce à nos offres de voyages en réalité augmentée.<br/> <br/>
            Que vous rêviez de parcourir un endroit futuriste, de vivre dans un monde médiéval fantastique ou d'explorer des galaxies lointaines,
            nous vous offrons une immersion totale et inoubliable. <br/>
            Avec notre équipement de haute technologie, toutes les sensations sont reproduites : chaleur du soleil, vent sur votre visage, frissons d'un combat épique…  
             Il n'y a plus de différence entre fiction et réalité.
        </p>

    </div>
    <div id = "bloc2">
        <div id = "sousbloc2" > 
            <div class = " zone1 ">
             <p>Comment ça fonctionne ?</p>
             <ul>
                <li>Choisissez votre destination: Un univers cyberpunk, une jungle préhistorique, une mégapole intergalactique... Le choix est infini !</li>
                <li>Personnalisez votre expérience: Adaptez l'environnement, le scénario et même votre avatar pour une immersion totale.</li>
                <li>Vivez votre aventure: Grâce à notre technologie de pointe, interagissez avec un monde plus vrai que nature.</li>
                <li>Partagez l'expérience: Voyagez en solo ou en groupe, rencontrez d'autres explorateurs et vivez une aventure collaboratives.</li>
             </ul>
            </div>
            <div class = " zone1">
            <img src="contenu_css/casque_vr.png" alt="Casque VR" class="casque_vr">
            <p>Une technologie à la pointe</p>
            <ul>
                <li>Immersion sensorielle totale: Casques 8k, gants haptiques, plateformes de mouvement... </li>
                <li>Interactions intelligentes: Des IA avancées pour des dialogues naturels et des scénarios adaptatifs.</li>
                <li>Expérience multisensorielle: Odeurs, température, sons spatialisés...tout est pensé pour une immersion absolue.</li>            
            </ul>
            </div>
        </div>
    </div>
    
    <footer> 
        <p> <span class="Multivers">Multivers</span><span class="Trip">Trip</span></p>
        
    </footer>

</body>
</html>