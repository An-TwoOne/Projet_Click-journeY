<?php

sleep(2);

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['id'], $input['statut'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

$id = $input['id'];
if ($input['statut'] === "null") {
    $statut = null;
} else {
    $statut = $input['statut'];
}

$utilisateurs = json_decode(file_get_contents("données_json/utilisateurs.json"), true);

foreach ($utilisateurs as &$utilisateur) {
    if ($utilisateur['Id'] == $id) {
        $utilisateur['Statut'] = $statut ;
         
        break;
    }
}

file_put_contents("données_json/utilisateurs.json", json_encode($utilisateurs, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Statut mis à jour']);