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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <div class="killersContainer" id="killersContainer">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="killer" onclick="location.href='detalle.php?id=<?= $row['id_killer'] ?>'">
                    <button>
                        <img src="img/<?= $row['profile_picture'] ?>" alt="<?= $row['name_killer'] ?>" />
                    </button>
                    <h2><?= $row['alias'] ?></h2>
                    <h3><?= $row['name_descrip_killer'] ?></h3>
                </div>
            <?php endwhile; ?>
        </div>

    </section>

    <?php $conexion->close(); ?>
    <script> $(document).ready(function () { $('.killersContainer').slick({ setting- name: setting - value }); }); </script>

    <script src='js/myScript.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js"
        integrity="sha512-BzvgYEoHXuphX+g7B/laemJGYFdrq4fTKEo+B3PurSxstMZtwu28FHkPKXu6dSBCzbUWqz/rMv755nUwhjQypw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
        integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- para las flechas que no sé -->
    <script>
        $(document).ready(function () {
            
        });
    </script>

</body>

</html>