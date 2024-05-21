<?php
// Inclusion du fichier de configuration de la base de données
include 'config/db/db.php';

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
    $randomNumber = rand(1, 3);
    $status = ($randomNumber == 1) ? 'error' : 'normal';

    $updateSql = "UPDATE modules SET status = '$status' WHERE id = $moduleId";
    $conn->query($updateSql);

    // Insertion/mise à jour du statut dans la table module_status
    $statusForModuleStatus = ($status === 'error') ? 'inact' : 'active';
    $insertSql = "INSERT INTO module_status (module_id, status, timestamp) VALUES ($moduleId, '$statusForModuleStatus', NOW())
                  ON DUPLICATE KEY UPDATE status = '$statusForModuleStatus', timestamp = NOW()";
    $conn->query($insertSql);

    return $status;
}

// Récupération des ID des modules depuis la base de données
$sql = "SELECT id, type FROM modules";
$result = $conn->query($sql);

// Vérification si des modules existent dans la base de données
if ($result->num_rows > 0) {
    // Parcours des modules
    while ($row = $result->fetch_assoc()) {
        $moduleId = $row['id'];
        $moduleType = $row['type'];

        // Mise à jour aléatoire de l'état du module
        $status = updateModuleStatus($conn, $moduleId);

        // Génération d'une mesure aléatoire si le module fonctionne normalement
        if ($status === 'normal') {
            $measurement = generateMeasurement($moduleType);

            // Mise à jour de la dernière mesure dans la table module_data
            $updateSql = "UPDATE module_data SET measurement = $measurement, timestamp = NOW()
                WHERE module_id = $moduleId";
            $conn->query($updateSql);

            // Insertion de la mesure dans la table module_history
            $insertSql = "INSERT INTO module_history (module_id, measurement, timestamp)
                VALUES ($moduleId, $measurement, NOW())";
            $conn->query($insertSql);
        }
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>