<?php
session_start();
?>

<div class="bandeau">
        <div>
            <a href="page_accueil.php"><img src="contenu_css/logo.png" alt="logo"></a>
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
            ?>
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