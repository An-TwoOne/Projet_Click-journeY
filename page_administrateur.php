
<?php session_start();
    $utilisateurs = json_decode(file_get_contents("données_json/utilisateurs.json"), true);
   
    $utilisateurs_par_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $total_utilisateurs = count($utilisateurs);
    $total_pages = ceil($total_utilisateurs / $utilisateurs_par_page);
    $debut = ($page - 1) * $utilisateurs_par_page;
    $utilisateurs_affiches = array_slice($utilisateurs, $debut, $utilisateurs_par_page);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($utilisateurs_affiches as &$utilisateur) {
             
            if (isset($_POST['vip']) && in_array($utilisateur['Id'], $_POST['vip'])) {
                $utilisateur['Statut'] = "VIP";
            }
            
            elseif (isset($_POST['exclure']) && in_array($utilisateur['Id'], $_POST['exclure'])) {
                $utilisateur['Statut'] = "Exclu";
            }
            
            else {
                $utilisateur['Statut'] = null;
            }


            foreach ($utilisateurs as &$util) {
                if ($util['Id'] === $utilisateur['Id']) {
                    $util['Statut'] = $utilisateur['Statut'];
                    break;
                }
            }
        }
    
        file_put_contents("données_json/utilisateurs.json", json_encode($utilisateurs, JSON_PRETTY_PRINT));
        header("Location: page_administrateur.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip Administrateur</title>
    <link rel = "stylesheet" type = "text/css" href = "CSS/page_administrateur.css">
    <script type='text/javascript' src="JS/page_administrateur.js"></script>
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>
    <link href="contenu_css/icon.png" rel="icon">
</head>
<body>

    <header>
        <div><a href="page_accueil.php"><span class="Multivers">Multivers</span><span class="Trip">Trip</span></a></div>
        <div class="page_admin"> Administrateur</div>
    </header>

    
    <form method="post">
        
    <table>
        <tr>
            <td colspan="5">
                <button class="enregistrer" type="submit">Enregistrer</button>
            </td>
        </tr>
        <tr class ="entete1"> 
            <th colspan="3">Utilisateurs</th>
            <th rowspan="2">VIP</th>
            <th rowspan="2">Exclure</th>
        </tr>
        <tr class="entete2">
            <td>Nom</td>
            <td>Prénom</td>
            <td>Email</td>
        </tr>
        <?php foreach ($utilisateurs_affiches as $utilisateur): ?>
            <tr id="contenu">
                <td><?= htmlspecialchars($utilisateur['Nom']) ?></td>
                <td><?= htmlspecialchars($utilisateur['Prenom']) ?></td>
                <td><?= htmlspecialchars($utilisateur['Mail']) ?></td>
                <td><input type="checkbox" name="vip[]" class="check_vip" value="<?= $utilisateur['Id'] ?>" <?= $utilisateur['Statut'] === "VIP" ? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="exclure[]" class="check_exclu" value="<?= $utilisateur['Id'] ?>" <?= $utilisateur['Statut'] === "Exclu" ? 'checked' : '' ?>></td>
            </tr>
        <?php endforeach; ?>

    </table>
        
    </form>

    <div class="pages">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"> <?= $i ?> </a>
        <?php endfor; ?>
    </div>

</body>
</html>