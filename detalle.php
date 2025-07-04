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

    <div class="navbar ">
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
        <div class="upContainer">
            <div class="profilePic">
                <img src="img/<?= $killer['profile_picture'] ?>" alt="<?= $killer['alias'] ?>">
                <div>
                    <h2><?= strtoupper($killer['alias']) ?></h2>
                    <h3><?= $killer['name_descrip_killer'] ?></h3>
                </div>
            </div>

        </div>

        <!-- TEXTO EXPEDIENTE -->
        <div class="expediente">
            <section class="informacion" id="informacion">
                <h2>INFORMACIÓN GENERAL</h2>
                <div class="row align-items-center gx-5">
                    <div class="col-md-6">
                        <p><b>Nombre completo:</b> <?= nl2br($killer['name_killer']) ?></p>
                        <p><b>Alias:</b> <?= nl2br($killer['alias']) ?></p>
                        <p><b>Fecha de nacimiento:</b> <?= nl2br($killer['birth_date']) ?></p>
                        <p><b>Lugar de nacimiento:</b> <?= nl2br($killer['birth_place']) ?></p>
                        <p><b>Periodo de actividad:</b> <?= nl2br($killer['period_activity_init']) ?>-<?= nl2br($killer['period_activity_end']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <div class="videoContainer">
                            <div class="video">
                                <video controls class="w-100">
                                    <source src="vd/<?= $killer['video_killer'] ?>" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
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
                <h2>VÍCTIMAS</h2>
                <div class="accordion" id="accordionExample">
                    <?php
                    $index = 0;
                    while ($victima = $query_victims->fetch_assoc()) {
                        $isFirst = $index === 0 ? 'show' : '';
                        $isCollapsed = $index === 0 ? '' : 'collapsed';
                    ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?= $index ?>">
                                <button class="accordion-button <?= $isCollapsed ?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                                    <?= htmlspecialchars($victima['name_victims']) ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $isFirst ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong><?= nl2br(htmlspecialchars($victima['info'])) ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php
                        $index++;
                    }
                    ?>
                </div>
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

</body>

</html>