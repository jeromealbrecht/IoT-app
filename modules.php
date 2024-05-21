<!-- get modules status -->
<?php
include './config/db/db.php';
include './includes/header.php';
?>

<div class="container text-center mt-5">
    <div id="notification" class="notification">
        <i class="fas fa-check"></i>
        <span>État des modules ok</span>
    </div>

    <h2>Modules</h2>
    <a class="btn btn-primary mb-3 mt-3" href="add_module.php">Ajouter un module</a>
</div>

<?php
$sql = "SELECT * FROM modules";
$result = $conn->query($sql);
?>

<div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4" id="module-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $moduleId = $row["id"];
                $moduleName = $row["name"];
                $moduleDescription = $row["description"];
                $moduleType = $row["type"];
                $moduleManufacturer = $row["manufacturer"];
                $moduleInstalledAt = $row["installed_at"];

                echo '
                <div class="col" data-module-id="' . $moduleId . '">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">' . $moduleName . '</h5>
                            <p class="card-text text-color">Description: ' . $moduleDescription . '</p>
                            <p class="card-text text-color">Type: ' . $moduleType . '</p>
                            <p class="card-text text-color">Manufacturer: ' . $moduleManufacturer . '</p>
                            <p class="card-text text-color">Installed at: ' . $moduleInstalledAt . '</p>
                            <p class="card-text text-color module-status"></p>
                            <div class="mt-auto d-grid gap-2">
                                <a class="text-color btn btn-primary mb-2 m-w" href="edit_module.php?id=' . $moduleId . '">Edit</a>
                                <a class="text-color btn btn-info mb-2 m-w" href="module_status.php?id=' . $moduleId . '">View Details</a>
                                <a href="#" class="text-color btn btn-danger mb-2 m-w" onclick="confirmDelete(' . $moduleId . ')">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col">';
            echo '<p>No modules found.</p>';
            echo '</div>';
        }
        $conn->close();
        ?>
    </div>
</div>

<!-- get module status -->

<?php include 'includes/footer.php'; ?>