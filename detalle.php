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

$query_victims = $conexion->query("SELECT * FROM victims WHERE killer_id = $id");


// Si no encuentra datos, redirige
if (!$killer) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Paloma" />
    <title><?= $killer['name_killer'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>

    <!-- BARRA DE NAVEGACIÓN -->

    <div class="navbar" id="mainNav">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link" href="#informacion" alt="Información">Información</a></li>
            <li class="nav-item"><a class="nav-link" href="#perfilPsicologico" alt="Perfil Psicológico">Perfil psicológico</a></li>
            <li class="nav-item"><a class="nav-link" href="#modusOperandi" alt="Modus Operandi">Modus Operandi</a></li>
            <li class="nav-item"><a class="nav-link" href="#victimas" alt="Víctimas">Víctimas</a></li>
            <li class="nav-item"><a class="nav-link" href="#resolucion" alt="Resolución">Resolución</a></li>
        </ul>
    </div>

    <header class="headerKiller">
        <div class="profilePic">
            <img src="img/<?= $killer['profile_picture'] ?>" alt="<?= $killer['alias'] ?>">
            <div>
                <h2><?= strtoupper($killer['alias']) ?></h2>
                <h3><?= $killer['name_descrip_killer'] ?></h3>
            </div>
        </div>
        <!-- BOTÓN HOME -->
        <div class="homeContainer">
            <a href="index.php" class="boton-home"><img src="./img/icons/home.png" alt=""></a>
        </div>
        </div>

    </header>

    <main class="contentLayout">

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
                <div>
                    <h2>PERFIL PSICOLÓGICO</h2>
                    <p><?= nl2br($killer['psico_profile']) ?></p>
                </div>

            </section>

            <section class="modusOperandi" id="modusOperandi">
                <h2>MODUS OPERANDI</h2>
                <p><?= nl2br($killer['modus_operandi']) ?></p>

            </section>

            <section class="victimas" id="victimas">
            </section>


            <section class="resolucion" id="resolucion">
                <h2>RESOLUCIÓN</h2>
                <p><?= nl2br($killer['resolución']) ?></p>
            </section>
        </div>




    </main>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src='/js/myScript.js'></script>
    <script src="js/navbar.js"></script>


</body>

</html>