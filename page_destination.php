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
        <form>
            <div class="recherche">
                <span class="material-symbols-outlined">search</span>
                <input class="recherche_rapide" type="search" name="recherche_rapide" placeholder="Rechercher...">
            </div>
        </form>
    </div>

    <div class="texte">
        <h3>Nos meilleures ventes</h3>
        <img src="contenu_css/tendance.png" alt="tendance">
    </div>
    <div id="conteneur">
        <div class="contenu"> 
            <img src="contenu_css/ville_futur.png" alt="ville_futur">
            <p>Monde Futuriste</p>
            <span>Voyagez en l’an 2130 et explorez un monde ultra-technologique.</span>
            <div> <a class="voir_plus" href="voyage.php?nom=Monde futuriste">Voir+</a> à partir de 1875€</div>
        
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_espace.png" alt="voyage_espace">
            <p>Voyage Intergalactique</p>
            <span>Partez à la découverte de l’univers, visitez des planètes inconnues et rencontrez des civilisations extraterrestres.</span>
            <div><a class="voir_plus" href="voyage.php?nom=voyage intergalactique">Voir+</a>à partir de 2360€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_medieval.png" alt="voyage_medieval">
            <p>Aventure Médiévale</p>
            <span>Plongez dans l’univers des chevaliers et revivez l’épopée du Moyen Âge à travers châteaux, tournois et légendes fascinantes.</span>
            <div><a class="voir_plus" href="voyage.php?nom=voyage médiéval">Voir+</a>à partir de 1240€</div>
        </div>
        <div class="contenu">
            <img src="contenu_css/jurrasique.png" alt="voyage_dinosaure">
            <p>Épopée Jurassique</p>
            <span>Remontez à l’ère des dinosaures, explorez une jungle primitive et croisez des créatures titanesques.</span>
            <div><a  class="voir_plus" href="voyage.php?nom=Épopée Jurassique">Voir+</a>à partir de 2530€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_pirate.png" alt="voyage_pirate">
            <p>Île des Pirates</p>
            <span>Naviguez sur les mers du XVIIe siècle, affrontez des corsaires et trouvez des trésors enfouis.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Île des pirates">Voir+</a>à partir de 2230€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/farwest.png" alt="voyage_farwest">
            <p>Expédition Far West</p>
            <span>Partez à la conquête de l’Ouest sauvage, devenez un hors-la-loi ou un shérif et affrontez duels, braquages et chasseurs de primes !</span>
            <div><a class="voir_plus" href="voyage.php?nom=Expédition Far West">Voir+</a>à partir de 1750€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/Gotham.png" alt="voyage_gothamcity">
            <p>Gotham City</p>
            <span>Voyagez à travers Gotham, une ville pleine de mystères, en proie à la criminalité et aux super-vilains, où chaque coin de rue révèle une nouvelle intrigue.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Gotham City">Voir+</a>à partir de 1300€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_japon.png" alt="japon_feodal">
            <p>Japon Féodal</p>
            <span>Revivez l’époque des samouraïs et des shoguns, entre temples sacrés, katanas affûtés et code de l’honneur.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Japon Féodal">Voir+</a>à partir de 1620€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_sorcier.png" alt="academie_sorcellerie">
            <p>Académie de Sorcellerie</p>
            <span>Apprenez la magie, fabriquez des potions et affrontez des créatures mythiques dans une école pleine de mystères et de sorts.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Académie de Sorcellerie">Voir+</a>à partir de 1950€</div>

        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_atlantide.png" alt="atlantide">
            <p>Atlantide Perdu</p>
            <span>Explorez les vestiges d’une civilisation sous-marine oubliée, entre merveilles architecturales et créatures abyssales.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Atlantide Engloutie">Voir+</a>à partir de 990€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_pixel.png" alt="pixel_world">
            <p>Pixel World</p>
            <span>Plongez dans un univers rétro où chaque niveau est un défi rempli de pièges, de boss et de bonus cachés.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Pixel World">Voir+</a>à partir de 1210€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_grece.png" alt="voyage_grece_antique">
            <p>Odyssée Antique</p>
            <span>Revivez l'âge d'or de la Grèce antique : arpentez les temples d’Athènes, combattez aux côtés des Spartiates et croisez dieux et créatures mythologiques.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Odyssée Antique">Voir+</a>à partir de 1980€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_egypte.png" alt="voyage_egypte_antique">
            <p>Voyage en Égypte</p>
            <span>Explorez les rives du Nil, pénétrez dans les pyramides interdites et assistez aux rituels des pharaons sous le regard des dieux égyptiens.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Mystères d'Égypte">Voir+</a>à partir de 1030€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_viking.png" alt="voyage_nordique">
            <p>Expédition Nordique</p>
            <span>Parcourez les terres des Vikings, croisez Odin, Thor et Loki, et préparez-vous au Ragnarök dans un monde où mythes et réalité ne font qu’un.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Légendes Nordiques">Voir+</a>à partir de 1990€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_apocalypse.png" alt="voyage_post_apocalyptique">
            <p>Terres Dévastées</p>
            <span>Survivez dans un monde où la loi du plus fort règne. Enchaînez les courses-poursuites dans le désert et défiez les clans pour votre survie.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Terres Dévastées">Voir+</a>à partir de 1190€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_steampunk.png" alt="voyage_steampunk">
            <p>Monde SteamPunk</p>
            <span>Découvrez une ville rétro-futuriste où rouages, dirigeables et inventions folles donnent vie à un univers victorien fantastique.</span>
            <div><a class="voir_plus" href="voyage.php?nom=Cité à Vapeur">Voir+</a>à partir de 1720€</div>
        </div>

        

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