<?php
    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Mail = $_POST['email'];
        $Mdp = $_POST['Mot_de_passe'];

        $json_donnees = file_get_contents('données_json/utilisateurs.json');
        $utilisateurs = json_decode($json_donnees, true);

        $succes_connex = false;

        if (empty($Mail) || empty($Mdp)) {
            $erreur_message = "Tous les champs doivent être remplis";
        } else {

            foreach ($utilisateurs as $utilisateur) {
                if ($utilisateur['Mail'] === $Mail) {
                    if (password_verify($Mdp, $utilisateur['Mdp'])) {
                        if ($utilisateur['Statut'] == "Exclu") {
                            $erreur_message = "Votre compte a été bloqué";
                            $succes_connex = false;
                        } else {
                            $succes_connex = true;
                            $_SESSION["Mail"] = $Mail;
                            $_SESSION["Id"] = $utilisateur["Id"];
                            $_SESSION["Prenom"] = $utilisateur["Prenom"];
                            $_SESSION["Nom"] = $utilisateur["Nom"];
                            $_SESSION["Mobile"] = $utilisateur["Mobile"];
                            $_SESSION["Username"] = $utilisateur["Username"];

                        }
                        break; 
                    } else {
                        $erreur_message = "Identifiants incorrects";
                    }
                }
            }
            if (!$succes_connex) {
                if (!isset($erreur_message)) {
                    $erreur_message = "Identifiants incorrects";
                }
            }
          
            if ($succes_connex && !isset($_SESSION['message'])) {
                header("Location: page_accueil.php");
                exit();
            }else if ($succes_connex && isset($_SESSION['message'])) {
                unset($_SESSION["message"]);
                header("Location: page_profil.php");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip connexion</title>
    <link rel = "stylesheet" type = "text/css" href = "page_connexion.css">
    <link href="contenu_css/icon.png" rel="icon">
</head>
<body>
    <div class="bandeau">
        <div>
            <a href="page_accueil.html"><img src="contenu_css/logo.png" alt="logo"></a>
            <a href="page_accueil.html">Accueil</a>
            <a href="page_destination.html">Destinations</a>
            <a href="page_destination.html#filtres"><img src="contenu_css/recherche_gris.png" alt="logo_recherche">Rechercher</a>
        </div>   
        <div>
            <a href="page_inscription.php">inscription</a> 
            <span>|</span>
            <a href="page_profil.php"><img src="contenu_css/icon_profil_gris.png" alt="Profil"></a>
        </div>
    </div>
    <div class="bloc_inscription">
    <div class="containere">
        <?php
        if (isset($_SESSION["message"])) {
            echo "<p class ='connecter'>" . $_SESSION["message"] . "</p>";
        }
        ?>
        <form method="post">
        <fieldset>
        <legend>
            <b class="titre"> Connexion </b>
        </legend>
            <input type="search" name="email"placeholder="Adresse-Mail" required/>
        <input type="password" name="Mot_de_passe" id="password" placeholder="Mot de passe" />
        
        <?php
        if (isset($erreur_message)) {
            echo "<p class='erreur_message'>$erreur_message</p>";
        }
        ?>
        </fieldset>
        
        <button type="submit">se connecter</button>
    </form>
    </div> 
    </div>

</body>
</html>
