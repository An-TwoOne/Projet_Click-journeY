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
                            $_SESSION["UserName"] = $utilisateur["UserName"];
                            $_SESSION["Admin"] = $utilisateur["Admin"];
                            $_SESSION["Statut"] = $utilisateur["Statut"];

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
                if($_SESSION['message'] === "Connecter vous pour accéder aux voyages"){
                    unset($_SESSION["message"]);
                    header("Location: page_destination.php");
                    exit();

                }else{
                    unset($_SESSION["message"]);
                    header("Location: page_profil.php");
                    exit();
                }
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
    <link rel = "stylesheet" type = "text/css" href = "CSS/page_connexion.css">
    <script type='text/javascript' src="JS/page_connexion.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "CSS/header.css">
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
    <link href="contenu_css/icon.png" rel="icon">
</head>
<body>
    <?php include('header.php') ?>
    
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
                <input id="email" type="search" name="email"placeholder="Adresse-Mail" required/>
                <div class="mdp-conteneur">
                    <input id="Mot_de_passe" type="password" name="Mot_de_passe" id="password" placeholder="Mot de passe" />
                    <img src="contenu_css/oeil_icon_blanc.png" class="aff-mdp" alt="Afficher/Masquer">
                </div>
        
            <?php
                if (isset($erreur_message)) {
                echo "<p class='erreur_message'>$erreur_message</p>";
                }
            ?>
        </fieldset>
        
            <button type="submit">se connecter</button>
        </form>

            <span class="message_inscription">Vous n’avez pas encore de compte ?</span>
            <a  id="inscription" class="message_inscription" href="page_inscription.php">Inscription</a>
        </div>  
        
    </div>

</body>
</html>