<?php
// Inclure le fichier de configuration de la base de données
include 'config/db/db.php';
include 'includes/header.php';

// Vérifier si l'ID du module est passé en paramètre GET
if (isset($_GET['id'])) {
    $moduleId = $_GET['id'];

    // Requête SQL pour supprimer les données liées au module dans la table module_data
    $deleteDataSql = "DELETE FROM module_data WHERE module_id = $moduleId";

    if ($conn->query($deleteDataSql) === true) {
        // Suppression des données de module_data réussie, maintenant supprimer les données de module_status
        $deleteStatusSql = "DELETE FROM module_status WHERE module_id = $moduleId";

        if ($conn->query($deleteStatusSql) === true) {
            // Suppression des données de module_status réussie, maintenant supprimer les données de data
            $deleteDataSql = "DELETE FROM data WHERE module_id = $moduleId";

            if ($conn->query($deleteDataSql) === true) {
                // Suppression des données de data réussie, maintenant supprimer le module de la table modules
                $deleteModuleSql = "DELETE FROM modules WHERE id = $moduleId";

                if ($conn->query($deleteModuleSql) === true) {
                    // Suppression du module réussie, afficher le message de succès avec SweetAlert
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: 'Le module a été supprimé avec succès.',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'modules.php';
                                }
                            });
                          </script>";
                    exit();
                } else {
                    // Erreur lors de la suppression du module, afficher le message d'erreur avec SweetAlert
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Une erreur s\'est produite lors de la suppression du module : " . $conn->error . "',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'modules.php';
                                }
                            });
                          </script>";
                    exit();
                }
            } else {
                // Erreur lors de la suppression des données, afficher le message d'erreur avec SweetAlert
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur s\'est produite lors de la suppression des données du module : " . $conn->error . "',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'modules.php';
                            }
                        });
                      </script>";
                exit();
            }
        } else {
            // Erreur lors de la suppression des données de module_status, afficher le message d'erreur avec SweetAlert
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur s\'est produite lors de la suppression des données de module_status : " . $conn->error . "',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'modules.php';
                        }
                    });
                  </script>";
            exit();
        }
    } else {
        // Erreur lors de la suppression des données de module_data, afficher le message d'erreur avec SweetAlert
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur s\'est produite lors de la suppression des données de module_data : " . $conn->error . "',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'modules.php';
                    }
                });
              </script>";
        exit();
    }
} else {
    // Si l'ID du module n'est pas spécifié, afficher le message d'erreur avec SweetAlert
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'ID du module non spécifié.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'modules.php';
                }
            });
          </script>";
    exit();
}

// Fermer la connexion à la base de données
$conn->close();
?>