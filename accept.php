<?php
    session_start();

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['Id'])) {
        header("Location: page_connexion.php");
        $_SESSION['message'] = "Connectez-vous pour accéder à vos voyages";
        exit();
    }

    // Récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['Id'];
    
    // Charger les données de paiement depuis le fichier JSON
    $json_paiements = file_get_contents('données_json/paiement.json');
    $paiements = json_decode($json_paiements, true);
    
    // Filtrer les paiements acceptés pour cet utilisateur
    $voyages_acceptes = [];
    foreach ($paiements as $paiement) {
        if ($paiement['Statut'] === 'accepted' && $paiement['ID'] === $user_id) {
            // Vérifier si ce voyage n'est pas déjà dans la liste (éviter les doublons)
            $voyage_existe = false;
            foreach ($voyages_acceptes as $voyage) {
                if ($voyage['Identification transaction'] === $paiement['Identification transaction']) {
                    $voyage_existe = true;
                    break;
                }
            }
            
            if (!$voyage_existe) {
                $voyages_acceptes[] = $paiement;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiversTrip - Mes Voyages</title>
    <link rel="stylesheet" type="text/css" href="CSS/page_profil.css">
    <link rel="stylesheet" type="text/css" href="CSS/header.css">
     <link rel="stylesheet" type="text/css" href="CSS/accept.css">
    <link href="contenu_css/icon.png" rel="icon">
    <link id="theme" rel="stylesheet" href="CSS/commun.css">
    <script type='text/javascript' src="JS/theme_couleur.js"></script>

   
</head>
<body>

    <?php include('header.php') ?>

    <div class="profile-container">
        <h1>Mes Voyages</h1>
        
        <div class="profile-nav">
            <a href="page_profil.php" class="nav-tab">Informations</a>
            <a href="paiement.php" class="nav-tab active">Mes Voyages</a>
        </div>
        
        <div class="voyages-container">
            <?php if (empty($voyages_acceptes)): ?>
                <div class="no-voyages">
                    <p>Vous n'avez pas encore de voyages acceptés.</p>
                </div>
            <?php else: ?>
                <?php foreach ($voyages_acceptes as $voyage): ?>
                    <div class="voyage-card">
                        <div class="voyage-title"><?php echo htmlspecialchars($voyage['Titre']); ?></div>
                        
                        <div class="voyage-detail">
                            <span class="detail-label">Référence:</span>
                            <span><?php echo htmlspecialchars($voyage['Identification transaction']); ?></span>
                        </div>
                        
                        <div class="voyage-detail">
                            <span class="detail-label">Montant:</span>
                            <span><?php echo htmlspecialchars($voyage['Paiement']); ?> €</span>
                        </div>
                        
                        <div class="voyage-detail">
                            <span class="detail-label">Date de réservation:</span>
                            <span><?php echo htmlspecialchars($voyage['Date']); ?></span>
                        </div>
                        
                        <div class="voyage-detail">
                            <span class="detail-label">Statut:</span>
                            <span class="status-badge">Accepté</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>