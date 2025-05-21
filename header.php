<?php
session_start();

 $json_donnees = file_get_contents('données_json/utilisateurs.json');
 $utilisateurs = json_decode($json_donnees, true);

foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur['Id'] === $_SESSION['Id']) {
            if($utilisateur['Statut'] === "Exclu"){
                
                header("Location: page_connexion.php");
                $_SESSION['message'] = "Votre compte a été bloqué";
                session_destroy();
                exit();
        }
        
                   
    }
}

?>

<div class="bandeau">
        <div>
            <a href="page_accueil.php"><img id="logo_site" src="contenu_css/logo.png" alt="logo"></a>
            <a href="page_accueil.php">Accueil</a>
            <a href="page_destination.php">Destinations</a>
            <a href="page_destination.php#filtres"><img src="contenu_css/recherche_gris.png" alt="logo_recherche">Rechercher</a>
        </div>   
        <div>
            <?php
            $page_consultee = basename($_SERVER['PHP_SELF']);
            if (!isset($_SESSION["Id"])) {
                if ($page_consultee != "page_connexion.php") {
                    echo '<a href="page_connexion.php">connexion</a>';
                }
                if ($page_consultee != "page_inscription.php") {
                    echo '<a href="page_inscription.php">inscription</a>';
                }
            }
            ?>
            <?php
                if ( isset($_SESSION["Id"]) && $_SESSION["Admin"] === "oui") {
                    echo '<a href="page_administrateur.php">Administrateur</a>';
                }

                if (isset($_SESSION["Id"])){
                    echo '<a href="page_panier.php"><img src="contenu_css/panier_icon.png" alt="icon_panier"></a>';
                }
            ?>
            <img src="contenu_css/theme_icon.png" alt="theme_icon" id="theme_couleur" class="logo_theme">
            <span>|</span>
            <?php
                if (isset($_SESSION["Id"])) {
                    echo '<a href="page_profil.php"><img src="contenu_css/icon_profil_connecte.png" alt="Profil"></a>';
                } else {
                    echo '<a href="page_profil.php"><img src="contenu_css/icon_profil_gris.png" alt="Profil"></a>';
            }
            ?>
        </div>
</div>