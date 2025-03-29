
<?php
    session_start();
    if (!isset($_SESSION['Id'])) {
        header("Location: page_connexion.php");
        $_SESSION['message'] = "Connecter vous pour accéder à votre profil";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $_SESSION['Nom'] = $_POST['name'];
        $_SESSION['Mobile'] = $_POST['mobile'];
        $_SESSION['UserName'] = $_POST['username'];
        $_SESSION['Mail'] = $_POST['email'];

        $ancien_mdp = $_POST['ancien_mdp'];
        $nouveau_mdp = $_POST['nouveau_mdp'];
        $confirmation_mdp = $_POST['confirmation_mdp'];
    
        $json_donnees = file_get_contents('données_json/utilisateurs.json');
        $utilisateurs = json_decode($json_donnees, true);

        $erreur_mdp = "";
    
        foreach ($utilisateurs as &$utilisateur) {
            if ($utilisateur['Id'] === $_SESSION['Id']) {
                $utilisateur['Nom'] = $_SESSION['Nom'];
                $utilisateur['Mobile'] = $_SESSION['Mobile'];
                $utilisateur['UserName'] = $_SESSION['UserName'];
                $utilisateur['Mail'] = $_SESSION['Mail'];

                if (!empty($nouveau_mdp) || !empty($confirmation_mdp)) {
                    if (empty($ancien_mdp) || empty($nouveau_mdp) || empty($confirmation_mdp)) {
                        $erreur_mdp = "Tous les champs mot de passe doivent être remplis.";
                    } else if (!password_verify($ancien_mdp, $utilisateur['Mdp'])) {
                        $erreur_mdp = "Ancien mot de passe incorrect.";
                    } else if ($nouveau_mdp !== $confirmation_mdp) {
                        $erreur_mdp = "Les nouveaux mots de passe ne correspondent pas.";
                    } else {
                        // Met à jour le mot de passe si tout est correct
                        $utilisateur['Mdp'] = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
                    }
                }
            }
        }
        file_put_contents('données_json/utilisateurs.json', json_encode($utilisateurs));
        $_SESSION['profil_modifier'] = "Profil mis à jour avec succès";
        header("Location: page_profil.php");
        exit();
    }
?>
   



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip Profil</title>
    <link rel="stylesheet" type="text/css" href="page_profil.css">
    <link href="contenu_css/icon.png" rel="icon">
</head>
<body>

    <div class="bandeau">
        <div>
            <a href="page_accueil.php"><img src="contenu_css/logo.png" alt="logo"></a>
            <a href="page_accueil.php">Accueil</a>
            <a href="page_destination.html">Destinations</a>
            <a href="page_destination.html#filtres"><img src="contenu_css/recherche_gris.png" alt="logo_recherche">Rechercher</a>
        </div>   
        <div>
            <a href="page_connexion.php">connexion</a>
            <a href="page_inscription.php">inscription</a> 
        </div>
    </div>


    <form method="post">
        <div class="profile-container">
            <h1>Votre Profil</h1>
            <div class="profile-card">
                <div class="banner">
                    <img src="contenu_css/Gotham.png" alt="ville_futur" class="banner-img">
                    <button class="edit-btn banner-edit"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                </div>
                <div class="avatar-container">
                    <img src="contenu_css/photo_profil.png" alt="shiruy" class="avatar">
                    <button class="edit-btn avatar-edit"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                </div>
                <div class="profile-info">
                    <label>Nom du profil</label>
                    <input type="text" name="name" value="<?php echo $_SESSION['Nom']; ?>" placeholder="Nom" >
                    <button  class="edit-btn"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                    <p class="description">Ceci se voit dans votre foyer, et peut être modifié à tout moment.</p>
                   
                    <label>Nom d'utilisateur <span> (facultatif) </span></label>
                    <input type="text" name="username" value="<?php echo $_SESSION['UserName']; ?>" placeholder="Choisissez un nom d'utilisateur..." >
                    <button  class="edit-btn"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                    <p class="description">Créez un nom d'utilisateur pour être prêt pour tes futures expériences !</p>
                   
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $_SESSION['Mail']; ?>" placeholder="Entrez votre email" required>
                    <button class="edit-btn"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                    <label>Ancien mot de passe</label>
                    <input type="password" name="ancien_mdp" value="ancien_mdp">
            
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="nouveau_mdp" placeholder="Nouveau mot de passe">
                    <button class="edit-btn"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                    <label>Confirmation du mot de passe</label>
                    <input type="password" name="confirmation_mdp" placeholder="Confirmez le mot de passe">
                    <button class="edit-btn"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                    <label>Mobile</label>
                    <input type="tel"  name="mobile" value="<?php echo $_SESSION['Mobile']; ?>" placeholder="Numéro de téléphone" required pattern="[0-9]+" minlength="10" >
                    <button class="edit-btn"><img src="contenu_css/crayon_modifier.png" alt="Modifier" class="edit-icon"></button>
                </div>

            <?php
                if (isset($_SESSION['profil_modifier'])) {
                echo "<p class = 'profil_modifier' >". $_SESSION['profil_modifier'] ."</p>";
                unset($_SESSION['profil_modifier']); 
                }
            ?>

                <div class="buttons">
                    <button type="submit" class="save">ENREGISTRER</button>
                    <button type="reset" class="cancel">SE DECONNECTER</button>
                </div>
            </div>
        </div>
    </form>

    
</body>
</html>