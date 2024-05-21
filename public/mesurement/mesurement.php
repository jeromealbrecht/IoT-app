<?php
// Inclusion du fichier de configuration de la base de données
include '../../config/db/db.php';

// Fonction pour générer une mesure aléatoire pour un module
function generateMeasurement($moduleType) {
    switch ($moduleType) {
        case 'temperature':
            return rand(10, 40); // Génère une température aléatoire entre 10 et 40
        case 'speed':
            return rand(0, 100); // Génère une vitesse aléatoire entre 0 et 100
        // Ajoutez d'autres cas pour différents types de modules
        default:
            return rand(0, 100); // Valeur par défaut si le type de module n'est pas reconnu
    }
}

// Fonction pour mettre à jour l'état des modules de manière aléatoire
function updateModuleStatus($conn, $moduleId) {
    $status = (rand(1, 10) <= 8) ? 'normal' : 'error'; // 80% de chance d'être 'normal', 20% d'être 'error'
    
    $updateSql = "UPDATE modules SET status = '$status' WHERE id = $moduleId";
    $conn->query($updateSql);
    
    return $status;
}

// Récupération des données des modules depuis la base de données
$sql = "SELECT * FROM modules";
$result = $conn->query($sql);

// Vérification si des modules existent dans la base de données
if ($result->num_rows > 0) {
    $moduleData = array();
    
    // Parcours des données des modules
    while ($row = $result->fetch_assoc()) {
        $moduleId = $row['id'];
        $moduleType = $row['type'];
        
        // Mise à jour aléatoire de l'état du module
        $status = updateModuleStatus($conn, $moduleId);
        
        // Génération d'une mesure aléatoire si le module fonctionne normalement
        $measurement = ($status === 'normal') ? generateMeasurement($moduleType) : null;
        
        // Insertion de la mesure générée dans la table module_data
        if ($measurement !== null) {
            $insertSql = "INSERT INTO module_data (module_id, measurement) VALUES ($moduleId, $measurement)";
            $conn->query($insertSql);
        }
        
        // Création du tableau des données du module
        $module = array(
            'id' => $moduleId,
            'name' => $row['name'],
            'type' => $moduleType,
            'status' => $status,
            'measurement' => $measurement,
        );
        
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