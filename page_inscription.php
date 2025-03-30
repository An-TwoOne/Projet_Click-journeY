
<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['Nom'] = $_POST['name'];
        $_SESSION['Prenom'] = $_POST['prenom'];
        $_SESSION['Age'] = $_POST['age'];
        $_SESSION['Mail'] = $_POST['email'];
        $_SESSION['Pays'] = $_POST['country'];
        $_SESSION['Mdp'] = $_POST['Mot_de_passe'];
        $_SESSION['Mobile'] = $_POST['mobile'];
        $confirmation = $_POST['confirmation'];

            
        $json_donnees = file_get_contents('données_json/utilisateurs.json');
        $utilisateurs = json_decode($json_donnees, true);
        $id_existe = false;

        do {
            $_SESSION['Id'] = bin2hex(random_bytes(4)); 
            $id_existe = false;
            foreach ($utilisateurs as $utilisateur) {
                if ($utilisateur['Mail'] == $_SESSION['Mail']) {
                    $erreur_message = "Cet email a déjà un compte associé, veuillez vous connecter";
                    break 2;
                }
                if ($utilisateur['Id'] == $_SESSION['Id']) {
                    $id_existe = true;
                    break;
                }
            }
        } while ($id_existe); 

        if ($_SESSION['Mdp'] !== $confirmation) {
            $erreur_message = "Les mots de passe ne sont pas identiques ";
        }
            

        if (!isset($erreur_message)) {

            
            $nouvel_utilisateur = array(
                'Id' => $_SESSION['Id'],
                'Mail' => $_SESSION['Mail'],
                'Mdp' => password_hash($_SESSION['Mdp'], PASSWORD_DEFAULT),
                'Nom' => $_SESSION['Nom'],
                'Prenom' => $_SESSION['Prenom'],
                'Age' => $_SESSION['Age'],
                'Pays' => $_SESSION['Pays'],
                'Mobile' => $_SESSION['Mobile'],
                'Admin' => "Non",
                'UserName' => null,
                'Statut' => null,
            );

            array_push($utilisateurs, $nouvel_utilisateur);
            file_put_contents('données_json/utilisateurs.json', json_encode($utilisateurs));
            header("Location: page_accueil.php");
            exit();
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip inscription</title>
    <link rel = "stylesheet" type = "text/css" href = "page_inscription.css">
    <link rel = "stylesheet" type = "text/css" href = "header.css">
    <link href="contenu_css/icon.png" rel="icon">
</head>
<body>
    <?php include('header.php') ?>
    
    <div class="bloc_inscription">
    <div class="containere">
        <form method="post">
        <fieldset>
        <legend>
            <b class="titre"> Créer un compte </b>
        </legend>
            <input type="text" id="name" name="name" placeholder="Nom" required/>
            <input type="text" name="prenom" id="prenom" placeholder="Prenom" value="" required/>
            <input type="number" name="age" min="18" max="100" value="" step="1" placeholder="Âge" required/>
            <input type="email" name="email"placeholder="Adresse-Mail" required/>
        <div class="pays">Selectionner votre pays</div>
            <select name="country">
            <optgroup label="Europe">
            <option value="France">France</option>
            <option value="Italie">Italie</option>
            <option value="Angleterre">Angleterre</option>
            <option value="Allemagne">Allemagne</option>
            <option value="Espagne">Espagne</option>
            <option value="Pologne">Pologne</option>
            <option value="Croatie">Croatie</option>
            <option value="Suisse">Suisse</option>
            <option value="Finlande">Finlande</option>
            <option value="Belgique">Belgique</option>
        </optgroup>
            <optgroup label ="Asie">
            <option value="Chine">Chine</option>
            <option value="Japon">Japon</option>
            <option value="Coree">Coree du sud</option>
            <option value="Inde">Inde</option>
            <option value="France">Cambodge</option>
            <option value="France">Indonesie</option>
            <option value="France">Taïwan</option>
        </optgroup>
        <optgroup label="Amerique">
            <option value="USA">Etats-Unis</option>
            <option value="Mexique">Mexique</option>
            <option value="Paragay">Paragay</option>
            <option value="Argentine">Argentine</option>
            <option value="Bresil">Bresil</option>
            <option value="Uruguay">Uruguay</option>
            <option value="Republique">Republique Dominicaine</option>
            <option value="Haïti">Haïti</option>
            <option value="Colombie">Colombie</option>
            <option value="Canada">Canada</option>
        </optgroup>
            <optgroup label="Afrique">
            <option value="Cameroun">Cameroun</option>
            <option value="Congo-Brazzaville">Congo-Brazz</option>
            <option value="Côte d'ivoire">Côte d'ivoire</option>
            <option value="Madagascar">Madagascar</option>
            <option value="Maroc">Maroc</option>
            <option value="France">Algerie</option>
            <option value="Turquie">Turquie</option>
            <option value="Senegale">Senegale</option>
            <option value="Cap-Vert">cap-vert</option>
            <option value="Guinée">Guinee</option>
            <option value="Gabon">Gabon</option>
        </optgroup>
        </select>  
        <input type="password" name="Mot_de_passe" id="password" placeholder="Mot de passe" required minlength="8" />
        <input type="password" name="confirmation" id="password" placeholder="Confirmer mot de passe " required />
        <input type="tel" id="telephone" name="mobile" placeholder=" N°mobile" required pattern="[0-9]+" title="Veuillez entrer numero valide" minlength="10"/>
        <?php
        if (isset($erreur_message)) {
            echo "<p class='erreur_message'>$erreur_message</p>";
        }
        ?>

    </fieldset>
    <button type="submit">s'inscrire</button>


    </form>
    </div> 
    </div>
</body>
</html>
