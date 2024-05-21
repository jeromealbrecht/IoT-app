<?php
require 'vendor/autoload.php';
include 'config/db/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exporter le PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
    if (isset($_GET['id'])) {
        $moduleId = $_GET['id'];

        // Récupérer les données du module depuis la base de données
        $sql = "SELECT * FROM modules WHERE id = $moduleId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Créer un nouveau document PDF
            $pdf = new FPDF();
            $pdf->AddPage();

            // Ajouter le titre
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, utf8_decode('Détails du module'), 0, 1, 'C');

            // Ajouter les détails du module
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, 'Nom: ' . utf8_decode($row['name']), 0, 1);
            $pdf->Cell(0, 10, 'Description: ' . utf8_decode($row['description']), 0, 1);
            $pdf->Cell(0, 10, 'Type: ' . utf8_decode($row['type']), 0, 1);
            $pdf->Cell(0, 10, 'Fabricant: ' . utf8_decode($row['manufacturer']), 0, 1);
            $pdf->Cell(0, 10, utf8_decode('Installé le: ') . utf8_decode($row['installed_at']), 0, 1);

            // Nettoyer (effacer) le tampon de sortie et désactiver la mise en mémoire tampon de sortie
            ob_end_clean();
            // Générer le PDF et l'envoyer au navigateur
            $pdf->Output('module_' . $moduleId . '.pdf', 'I');
            exit();
        } else {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: "Module non trouvé.",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "modules.php";
                    }
                });
            </script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Erreur",
                text: "ID du module non spécifié.",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "modules.php";
                }
            });
        </script>';
    }

    $conn->close();
    ?>
</body>
</html>