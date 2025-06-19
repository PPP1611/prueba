<?php
include_once 'php/conexion.php';

$result = $conexion->query("SELECT * FROM killer_information");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Paloma" />
    <title>Injury</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <header class="masthead">
        <section id="start">
            <h1>INJURY</h1>
            <h2>Los casos más intrigantes de asesinos seriales</h2>
        </section>

        <div class="arrow" id="backgroundContainer">
            <button id="slideBtn"><i class="bi bi-caret-down-fill"></i></button>
        </div>
    </header>

    <section class="killerSection" id="serialKillersSection">

        <div class="userContainer" id="userContainer">
            <div id="filter">
                <button id="filterIcon"><i class="bi bi-filter-square"></i></button>
            </div>
            <div id="user">
                <button id="userIcon"><i class="bi bi-person-circle"></i></button>
            </div>
        </div>

        <section id="killersContainer">
            <div id="killersCarousel" class="carousel slide" data-bs-interval="false">
                <div class="carousel-inner">
                    <?php
                    $counter = 0;
                    while ($row = $result->fetch_assoc()):
                        // Iniciar nuevo slide cada 3 killers
                        if ($counter % 3 == 0):
                            $active = ($counter == 0) ? 'active' : '';
                            ?>
                            <div class="carousel-item <?= $active ?>">
                                <div class="row justify-content-center mx-auto" style="max-width: 1200px;">
                                <?php endif; ?>

                                <div class="col-md-4 text-center p-3">
                                    <div class="killer" onclick="location.href='detalle.php?id=<?= $row['id_killer'] ?>'">
                                        <button id="<?= strtolower(str_replace(' ', '_', $row['name_killer'])) ?>"
                                            class="killer-btn">
                                            <img src="img/<?= $row['profile_picture'] ?>" alt="<?= $row['name_killer'] ?>"
                                                class="img-fluid killer-img">
                                        </button>
                                        <h2><?= strtoupper($row['alias']) ?></h2>
                                        <h3><?= $row['name_descrip_killer'] ?></h3>
                                    </div>
                                </div>

                                <?php
                                $counter++;
                                // Cerrar slide cada 3 killers o al final
                                if ($counter % 3 == 0 || $counter == $result->num_rows):
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>

                <!-- Controles del carrusel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#killersCarousel"
                    data-bs-slide="prev" style="left: -100px; width: 80px;">
                    <span class="carousel-control-prev-icon" style="width: 90px; height: 90px;"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#killersCarousel"
                    data-bs-slide="next" style="right: -100px; width: 80px;">
                    <span class="carousel-control-next-icon" style="width: 90px; height: 90px;"></span>
                </button>
            </div>
        </section>
        <?php $conexion->close(); ?>


        <script src='js/myScript.js'></script>
</body>

</html>