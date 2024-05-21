<?php
session_start();
include 'config/db/db.php';
include 'includes/header.php';

if (isset($_GET['id'])) {
    $moduleId = $_GET['id'];

    // Récupérer les données du module depuis la base de données
    $sql = "SELECT * FROM modules WHERE id = $moduleId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <div class="container">
            <h1 class="mt-4">Détails du module</h1>
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                    <p class="card-text"><strong>Description :</strong> <?php echo $row['description']; ?></p>
                    <p class="card-text"><strong>Type :</strong> <?php echo $row['type']; ?></p>
                    <p class="card-text"><strong>Fabricant :</strong> <?php echo $row['manufacturer']; ?></p>
                    <p class="card-text"><strong>Installé le :</strong> <?php echo $row['installed_at']; ?></p>
                    <a class="btn btn-secondary mt-3" href="export_pdf.php?id=<?php echo $moduleId; ?>" target="_blank">Télécharger PDF</a>
                    <a class="btn btn-primary mt-3" href="modules.php">Retour aux modules</a>
                </div>
            </div>
            <div class="mt-4">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <?php
        // Récupérer les données pour le graphique depuis la base de données
        $sqlData = "SELECT timestamp AS date, value FROM module_data WHERE module_id = $moduleId ORDER BY timestamp";
        $resultData = $conn->query($sqlData);

        $labels = [];
        $values = [];

        if ($resultData->num_rows > 0) {
            while ($rowData = $resultData->fetch_assoc()) {
                $labels[] = $rowData['date'];
                $values[] = $rowData['value'];
            }
        }
        ?>
        <script>
            // Récupérer le contexte du canvas
            var ctx = document.getElementById('myChart').getContext('2d');

            // Créer le graphique
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        label: 'Données du module',
                        data: <?php echo json_encode($values); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <?php
    } else {
        echo "Module non trouvé.";
    }
} else {
    echo "ID du module non spécifié.";
}

$conn->close();
include 'includes/footer.php';
?>