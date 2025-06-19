<?php
include_once 'php/conexion.php';

// Obtener el id desde la URL
$id = $_GET['id'] ?? null;

// Si no hay id, redirige al inicio
if (!$id) {
    header("Location: index.php");
    exit();
}

// Consulta a la base de datos
$query = $conexion->query("SELECT * FROM killer_information WHERE id_killer = $id");
$killer = $query->fetch_assoc();

// Si no encuentra datos, redirige
if (!$killer) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="author" content="Paloma" />
    <title><?= $killer['name_killer'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>

    <!-- BARRA DE NAVEGACIÓN -->
    <header class="template">
        <div class="navbar">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="#informacion">Información</a></li>
                <li class="nav-item"><a class="nav-link" href="#perfilPsicologico">Perfil psicológico</a></li>
                <li class="nav-item"><a class="nav-link" href="#modusOperandi">Modus Operandi</a></li>
                <li class="nav-item"><a class="nav-link" href="#victimas">Víctimas</a></li>
                <li class="nav-item"><a class="nav-link" href="#resolucion">Resolución</a></li>
            </ul>
        </div>   
    </header>

    <main class="contentLayout">
        <div class="upContainer">
            <div class="profilePic">
                <img src="img/<?= $killer['profile_picture'] ?>" alt="<?= $killer['alias'] ?>">
                <div>
                    <h2><?= strtoupper($killer['alias']) ?></h2>
                    <h3><?= $killer['name_descrip_killer'] ?></h3>
                </div>
            </div>

            <div class="homeContainer">
                <a href="index.php" class="boton-home"><i class="bi bi-house-door-fill"></i></a>
            </div>
        </div>

        <!-- TEXTO EXPEDIENTE -->
        <div class="expediente">
            <section class="informacion" id="informacion">
                <p>Nombre completo: <?= nl2br($killer['name_killer']) ?></p>
                <p>Alias: <?= nl2br($killer['alias']) ?></p>
                <p>Fecha de nacimiento: <?= nl2br($killer['birth_date']) ?></p>
                <p>Lugar de nacimiento: <?= nl2br($killer['birth_place']) ?></p>
                <p>Periodo de actividad: <?= nl2br($killer['period_activity']) ?></p>
            </section>

            <section class="perfilPsicologico" id="perfilPsicologico">
                <h3>Infancia</h3>
                <p><?= nl2br($killer['psico_profile']) ?></p>
            </section>

            <section class="modusOperandi" id="modusOperandi">
            </section>

            <section class="victimas" id="victimas">
            </section>

            <section class="resolucion" id="resolucion">
            </section>
        </div>

        <!-- VIDEO -->
        <div class="videoContainer">
            <div class="video">
                <video width="240" height="420" controls>
                    <source src="vd/<?= $killer['video_killer'] ?>" type="video/mp4">
                </video>
            </div>
        </div>


    </main>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src='/js/myScript.js'></script> 

</body>
</html>
