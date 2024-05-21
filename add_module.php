<!-- add_module.php -->
<?php
include 'config/db/db.php';
include 'includes/header.php';

// Fonction pour valider et nettoyer les entrées
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire et les valider
    $name = validateInput($_POST["name"]);
    $description = validateInput($_POST["description"]);
    $type = validateInput($_POST["type"]);
    $manufacturer = validateInput($_POST["manufacturer"]);
    $installed_at = validateInput($_POST["installed_at"]);

    // Vérifier si les champs requis sont vides
    if (empty($name) || empty($installed_at)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Champs obligatoires',
                    text: 'Veuillez remplir tous les champs obligatoires.',
                    confirmButtonText: 'OK'
                });
              </script>";
    } else {
        // Vérifier si les entrées contiennent des caractères non autorisés
        if (!preg_match("/^[\p{L}\p{N}\p{P}\p{S}\p{M}\s]+$/u", $name) ||
            (!empty($description) && !preg_match("/^[\p{L}\p{N}\p{P}\p{S}\p{M}\s]+$/u", $description)) ||
            (!empty($type) && !preg_match("/^[\p{L}\p{N}\p{M}\s]+$/u", $type)) ||
            (!empty($manufacturer) && !preg_match("/^[\p{L}\p{N}\p{P}\p{S}\p{M}\s]+$/u", $manufacturer))) {
            echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Caractères non autorisés',
                        text: 'Caractères non autorisés détectés. Veuillez vérifier vos entrées.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        } else {
            // Insérer le nouveau module dans la base de données
            $sql = "INSERT INTO modules (name, description, type, manufacturer, installed_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $description, $type, $manufacturer, $installed_at);

            if ($stmt->execute()) {
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: 'Nouveau module ajouté avec succès.',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'modules.php';
                            }
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur lors de l\'ajout du module: " . $stmt->error . "',
                            confirmButtonText: 'OK'
                        });
                      </script>";
            }

            $stmt->close();
        }
    }
}
?>

<div class="container d-flex justify-content-center flex-column align-items-center mt-5">
    <div class="mt-3">
        <a href="modules.php" class="btn btn-secondary">Retour aux modules</a>
    </div>

    <!-- Formulaire pour ajouter un nouveau module -->
    <form action="add_module.php" class="col-md-4" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nom:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="5"><?php echo isset($description) ? $description : ''; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type:</label>
            <input type="text" class="form-control" id="type" name="type"
                value="<?php echo isset($type) ? $type : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="manufacturer" class="form-label">Fabricant:</label>
            <input type="text" class="form-control" id="manufacturer" name="manufacturer"
                value="<?php echo isset($manufacturer) ? $manufacturer : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="installed_at" class="form-label">Installé le:</label>
            <input type="datetime-local" class="form-control" id="installed_at" name="installed_at"
                 value="<?php echo isset($installed_at) ? $installed_at : ''; ?>" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Ajouter le module</button>
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<?php
include 'includes/footer.php';
?>