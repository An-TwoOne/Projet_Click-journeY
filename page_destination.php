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
            <div>à partir de 1875€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_espace.png" alt="voyage_espace">
            <p>Voyage Intergalactique</p>
            <span>Partez à la découverte de l’univers, visitez des planètes inconnues et rencontrez des civilisations extraterrestres.</span>
            <div>à partir de 2360€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_medieval.png" alt="voyage_medieval">
            <p>Aventure Médiévale</p>
            <span>Plongez dans l’univers des chevaliers et revivez l’épopée du Moyen Âge à travers châteaux, tournois et légendes fascinantes.</span>
            <div>à partir de 1240€</div>
        </div>
        <div class="contenu">
            <img src="contenu_css/jurrasique.png" alt="voyage_dinosaure">
            <p>Épopée Jurassique</p>
            <span>Remontez à l’ère des dinosaures, explorez une jungle primitive et croisez des créatures titanesques.</span>
            <div>à partir de 2530€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/voyage_pirate.png" alt="voyage_pirate">
            <p>Île des pirates</p>
            <span>Naviguez sur les mers du XVIIe siècle, affrontez des corsaires et trouvez des trésors enfouis.</span>
            <div>à partir de 2230€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/farwest.png" alt="voyage_farwest">
            <p>Expédition Far West</p>
            <span>Partez à la conquête de l’Ouest sauvage, devenez un hors-la-loi ou un shérif et affrontez duels, braquages et chasseurs de primes !</span>
            <div>à partir de 1750€</div>
        </div>
        <div class="contenu"> 
            <img src="contenu_css/Gotham.png" alt="voyage_gothamcity">
            <p>Gotham City</p>
            <span>Voyagez à travers Gotham, une ville pleine de mystères, en proie à la criminalité et aux super-vilains, où chaque coin de rue révèle une nouvelle intrigue.</span>
            <div>à partir de 1300€</div>
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