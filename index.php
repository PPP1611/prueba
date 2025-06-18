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
</body>

</html>