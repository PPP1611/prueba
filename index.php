<?php
include_once 'php/conexion.php';

$where = [];
$groupBy = true; // por defecto, agrupamos por asesino

// Filtro por nombre del asesino
if (!empty($_GET['name_killer'])) {
    $name = $conexion->real_escape_string($_GET['name_killer']);
    $where[] = "ki.name_killer LIKE '%$name%'";
}

// Filtro por alias
if (!empty($_GET['alias'])) {
    $alias = $conexion->real_escape_string($_GET['alias']);
    $where[] = "ki.alias LIKE '%$alias%'";
}

// Filtro por nombre de la víctima
if (!empty($_GET['victim_name'])) {
    $victim = $conexion->real_escape_string($_GET['victim_name']);
    $where[] = "v.name LIKE '%$victim%'";
    $groupBy = false; // si se filtra por víctima, no agrupamos
}

// Filtro por época (ahora usando period_start y period_end)
if (!empty($_GET['start_year'])) {
    $start = (int)$_GET['start_year'];
    $where[] = "ki.period_start >= $start";
}

if (!empty($_GET['end_year'])) {
    $end = (int)$_GET['end_year'];
    $where[] = "ki.period_end <= $end";
}


// Armar condición
$condition = "";
if (!empty($where)) {
    $condition = "WHERE " . implode(" AND ", $where);
}

// Consulta final
$sql = "
SELECT ki.*, v.name AS victim_name, v.crime_place
FROM killer_information ki
JOIN killer_victims kv ON ki.id_killer = kv.id_killer
JOIN victims v ON kv.id_victims = v.id_victims
$condition
";

if ($groupBy) {
    $sql .= " GROUP BY ki.id_killer";
}

$result = $conexion->query($sql);



if ($result->num_rows == 0) {
    $filterDisabled = true;
    $message = "No se encontraron datos con esos filtros.";
} else {
    $filterDisabled = false;
    $message = "";
}


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
            <button id="slideBtn"><img src="./img/icons/arrow_down.png" alt=""></button>
        </div>
    </header>

    <section class="killerSection" id="serialKillersSection">

        <div class="userContainer" id="userContainer">
            <div class="filter">
                <button id="filterIcon"><img src="./img/icons/filter.png" alt=""></button>
            </div>
            <div id="user">
                <button id="userIcon"><img src="./img/icons/user.png" alt=""></button>
            </div>
        </div>

        <!-- Ventana modal de filtros -->
        <div id="filterModal" class="modal hidden">
            <div class="modal-content">
                <button class="close-btn" id="closeFilter">
                    <img src="./img/icons/close.png" alt="Cerrar" />
                </button>

                <h2 class="title_window">Filtros</h2>
                <form method="GET" action="">
                    <label>Nombre</label>
                    <input type="text" name="name_killer" placeholder="Buscar asesino" />

                    <label>Alias</label>
                    <input type="text" name="alias" placeholder="Buscar alias" />

                    <label>Lugar de actividad</label>
                    <div><input type="checkbox" disabled /> Europa</div>
                    <div><input type="checkbox" disabled /> América</div>
                    <div><input type="checkbox" disabled /> África</div>

                    <label>Víctimas</label>
                    <input type="text" name="victim_name" placeholder="Buscar víctima" />

                    <label>Época de actividad</label>
                    <div class="date-range">
                        <input type="text" name="start_year" placeholder="Mín (ej. 1970)" />
                        <input type="text" name="end_year" placeholder="Máx (ej. 1980)" />
                    </div>

                    <?php if ($message): ?>
                        <p style="color: red; font-weight: bold;"><?= $message ?></p>
                    <?php endif; ?>


                    <div class="btn_filter">
                        <button href="index.php">Borrar</button>

                        <button type="submit" <?= $filterDisabled ? 'disabled' : '' ?>>Filtrar</button>

                    </div>
                </form>
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
                                        <button id="<?= strtolower(str_replace(' ', '_', $row['name_killer'])) ?>" class="killer-btn">
                                            <img src="img/<?= $row['profile_picture'] ?>" alt="<?= $row['name_killer'] ?>" class="img-fluid killer-img">
                                        </button>
                                        <h2><?= strtoupper($row['alias']) ?></h2>
                                        <h3><?= $row['name_descrip_killer'] ?></h3>
                                    </div>
                                </div>

                                <?php
                                $counter++;
                                if ($counter % 3 == 0 || $counter == $result->num_rows):
                                ?>
                                </div> 
                            </div> 
                    <?php
                                endif;
                            endwhile;
                    ?>

                    <!-- Controles del carrusel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#killersCarousel" data-bs-slide="prev" style="left: -100px; width: 80px;">
                        <span class="carousel-control-prev-icon" style="width: 90px; height: 90px;"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#killersCarousel" data-bs-slide="next" style="right: -100px; width: 80px;">
                        <span class="carousel-control-next-icon" style="width: 90px; height: 90px;"></span>
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#killersCarousel" data-bs-slide="prev" style="left: -100px; width: 80px;">
            <span class="carousel-control-prev-icon" style="width: 90px; height: 90px;"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#killersCarousel" data-bs-slide="next" style="right: -100px; width: 80px;">
            <span class="carousel-control-next-icon" style="width: 90px; height: 90px;"></span>
        </button>
    </div>
</section>
    <?php $conexion->close(); ?>


        <script src='js/myScript.js'></script>
        <script src='js/ventana_emergente.js'></script>
</body>

</html>