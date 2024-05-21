<?php
// Inclure le fichier de configuration de la base de données et l'en-tête
include 'config/db/db.php';
include 'includes/header.php';
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Module Data</h2>

    <!-- Formulaire pour sélectionner un module -->
    <form action="data" method="post" class="mb-3">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-auto d-flex align-items-center">
                <label for="module" class="form-label me-2">Selectionner un module:</label>
            </div>
            <div class="col-sm-auto">
                <select id="module" name="module" class="form-select">
                    <option value="">Tout les modules</option>
                    <?php
                    // Récupérer tous les modules de la base de données
                    $sql = "SELECT * FROM modules";
                    $result = $conn->query($sql);
                    
                    // Créer une option pour chaque module dans la liste déroulante
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                        }
                    } else {
                        $errorMessage = "Pas de données trouvées";
                        $messageClass = "error-message";
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-auto">
                <input type="submit" value="Voir les données" class="btn btn-primary">
            </div>
        </div>
    </form>

    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer l'ID du module sélectionné
        $moduleId = $_POST["module"];

        // Si un module a été sélectionné, récupérer les données uniquement pour ce module
        // Sinon, récupérer toutes les données
        if (!empty($moduleId)) {
            $sql = "SELECT data.*, modules.name, modules.description, modules.type, modules.manufacturer, modules.status
                    FROM data 
                    INNER JOIN modules ON data.module_id = modules.id
                    WHERE data.module_id = $moduleId";
        } else {
            $sql = "SELECT data.*, modules.name, modules.description, modules.type, modules.manufacturer, modules.status
                    FROM data
                    INNER JOIN modules ON data.module_id = modules.id";
        }

        $result = $conn->query($sql);

        // Afficher les données dans un tableau HTML
        if ($result->num_rows > 0) {
            echo "<div class='table-responsive'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Module Name</th>
                                <th>Value</th>
                                <th class='d-none d-md-table-cell'>Timestamp</th>
                                <th class='d-none d-lg-table-cell'>Description</th>
                                <th class='d-none d-lg-table-cell'>Type</th>
                                <th class='d-none d-lg-table-cell'>Manufacturer</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td><a href='module_status.php?id=" . $row["module_id"] . "'>" . $row["name"] . "</a></td>
                        <td>" . $row["value"]. "</td>
                        <td class='d-none d-md-table-cell'>" . $row["timestamp"]. "</td>
                        <td class='d-none d-lg-table-cell'>" . $row["description"]. "</td>
                        <td class='d-none d-lg-table-cell'>" . $row["type"]. "</td>
                        <td class='d-none d-lg-table-cell'>" . $row["manufacturer"]. "</td>
                        <td>";
                if ($row["status"] == "active") {
                    echo "<span class='badge bg-success'>Active</span>";
                } elseif ($row["status"] == "inactive") {
                    echo "<span class='badge bg-warning'>Inactive</span>";
                } else {
                    echo "<span class='badge bg-danger'>Unknown</span>";
                }
                echo "</td>
                    </tr>";
            }
            echo "</tbody>
                    </table>
                </div>";
        } else {
            $errorMessage = "Pas de données trouvées";
            $messageClass = "error-message";
            
            // Afficher un message d'erreur avec SweetAlert
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Aucune donnée trouvée pour le module sélectionné.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    }

    // Fermer la connexion à la base de données et inclure le pied de page
    $conn->close();
    ?>
</div>

<?php include 'includes/footer.php'; ?>