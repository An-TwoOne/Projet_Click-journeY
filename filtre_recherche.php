<?php
 session_start();
?>


<div id="filtres" class="filtres_conteneur">
        <form id="filtre_recherche"  method="post">
            <h4 class="titre_filtres">Trouver votre voyage idéal</h4>
            <hr/>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" >

            <label for="duree">Durée du voyage:</label>
            <select id="duree" name="duree" >
                <option value="un_jour">un jour</option>
                <option value="plusieurs_jours">plusieurs jours</option>
                <option value="quelque_heures">quelque heures</option>
            </select>

            <label for="prix">Votre Budget (max):</label>
            <input type="range" id="prix" name="prix" min="800" max="5000" value="2500" step="100">
            <span id="aff_prix">2500€</span>
            

            <label for="experience">Expérience:</label>
            <input type="radio" id="experience_solo" name="experience" value="solo" >Solo
            <input type="radio" id="experience_group" name="experience" value="en_groupe" >en Groupe

            <label for="periode">Période voyage:</label>
            <input type="checkbox" id ="periode_voyage_passé" name="periode" value="Passé" >Passé
            <input type="checkbox" id ="periode_voyage_futur" name="periode" value="Futuriste" >Futuriste
            <input type="checkbox" id ="periode_voyage_réel" name="periode" value="Monde_réel">Monde réel

            <label for="promotion">En promotion:</label>
            <input type="checkbox" id ="promotion" name="promotion" value="oui" >Oui

            <label for="equipement">Niveau d'équipement:</label>
            <input type="radio" id="equipement_stand" name="equipement" value="Standard" >Standard
            <input type="radio" id="equipement_prem" name="equipement" value="Premium" >Premium
            <input type="radio" id="equipement_luxe" name="equipement" value="Luxe" >Luxe

            <label for="type">Type d'expérience:</label>
            <input type="checkbox" id ="type_ex_aven" name="type" value="Aventure" >Aventure
            <input type="checkbox" id ="type_ex_deten" name="type" value="Détente" >Détente
            <input type="checkbox" id ="type_ex_sensa" name="type" value="Sensationnel">Sensationnel

            <label for="univers">Univers:</label>
            <select id="univers" name="univers" >
                <option value="Tous">Tous</option>
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

