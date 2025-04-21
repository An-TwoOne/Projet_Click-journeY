<?php
 session_start();
?>


<div id="filtres" class="filtres_conteneur">
        <form  method="post">
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

