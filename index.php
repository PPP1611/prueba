<?php
include_once 'php/conexion.php';

$sql = "
SELECT DISTINCT ki.*
FROM killer_information ki
JOIN killer_victims kv ON ki.id_killer = kv.id_killer
JOIN victims v ON kv.id_victims = v.id_victims
";

$result = $conexion->query($sql);
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

                <label>Nombre</label>
                <input type="text" />

                <label>Alias</label>
                <input type="text" />

                <label>Lugar de actividad</label>
                <div><input type="checkbox" /> Europa</div>
                <div><input type="checkbox" /> América</div>
                <div><input type="checkbox" /> África</div>

                <label>Víctimas</label>
                <input type="text" />

                <label>Época de actividad</label>
                <div class="date-range">
                    <input type="text" placeholder="Mín" />
                    <input type="text" placeholder="Máx" />
                </div>

                <div class="btn_filter">
                    <button>Borrar</button>
                    <button>Filtrar</button>
                </div>
            </div>
        </div>



        <div id="killersContainer">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="killer" onclick="location.href='detalle.php?id=<?= $row['id_killer'] ?>'">
                    <button>
                        <img src="img/<?= $row['profile_picture'] ?>" alt="<?= $row['name_killer'] ?>" />
                    </button>
                    <h2><?= $row['name_killer'] ?></h2>
                    <h3><?= $row['alias'] ?></h3>
                </div>
            <?php endwhile; ?>
        </div>

    </section>

    <?php $conexion->close(); ?>


    <script src='js/myScript.js'></script>
    <script src='js/ventana_emergente.js'></script>
</body>

</html>