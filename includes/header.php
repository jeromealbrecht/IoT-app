<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- importer Boostrap en CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- import Sweet Alert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <!-- import Sweet Alert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <!-- importer jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- importer Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- importer les polices -->
    <link rel="stylesheet" href="../src/css/fonts.css">
    <!-- importer les styles -->
    <link rel="stylesheet" href="../src/css/custom.css">
    <!-- importer les icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>IoT Monitoring</title>
</head>
<body>
<header>
    <div class="container w-100 d-flex flex-column align-items-center mob-none">
        <h1 class="text-center mt-3">IoT Monitoring</h1>
        <nav class="col-3 text-center mt-3">
            <ul class="d-flex justify-content-around list-unstyled">
                <li><a href="/index" class="btn">Accueil</a></li>
                <li><a href="/modules" class="btn">Modules</a></li>
                <li><a href="/data" class="btn">Data</a></li>
            </ul>
        </nav>
    </div>

    <div class="hamburger-menu desk-none">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
        <ul class="nav-links desk-none nav-hidden">
            <li><a href="/index" class="btn">Accueil</a></li>
            <li><a href="/modules" class="btn">Modules</a></li>
            <li><a href="/data" class="btn">Data</a></li>
        </ul>
</header>

