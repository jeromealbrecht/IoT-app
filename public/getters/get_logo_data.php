<?php
// Logique pour récupérer les données du logo depuis la base de données ou toute autre source

$logoData = [
    'logoUrl' => './src/img/logo/ok_logo.png',
    'logoAlt' => 'Description du logo'
];

header('Content-Type: application/json');
echo json_encode($logoData);
?>
