<?php
// Inclusion du fichier de configuration de la base de données
include 'config/db/db.php';

// Récupération des données des modules depuis la base de données
$sql = "SELECT * FROM modules";
$result = $conn->query($sql);

// Vérification si des modules existent dans la base de données
if ($result->num_rows > 0) {
    $moduleData = array();
    
    // Parcours des données des modules
    while ($row = $result->fetch_assoc()) {
        $module = array(
            'id' => isset($row['id']) ? $row['id'] : null,
            'name' => isset($row['name']) ? $row['name'] : null,
            'field1' => isset($row['field1']) ? $row['field1'] : null,
            'field2' => isset($row['field2']) ? $row['field2'] : null,
            // Ajoutez d'autres champs de données selon votre structure de table
        );
        
        // Vérification de l'état de fonctionnement du module
        // Ajustez cette condition en fonction de votre logique métier
        if (isset($row['status']) && $row['status'] === 'error') {
            $module['status'] = 'error';
            
        } else {
            $module['status'] = 'normal';
        }
        
        $moduleData[] = $module;
    }
    
    // Renvoi des données au format JSON
    header('Content-Type: application/json');
    echo json_encode($moduleData);
} else {
    // Aucun module trouvé dans la base de données
    echo json_encode(array());
}

// Fermeture de la connexion à la base de données
$conn->close();
?>