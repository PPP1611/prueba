<?php
include_once 'php/conexion.php';

$where = [];
$groupBy = true; // agrupamos por defecto
$joinVictims = "";
$useVictimsJoin = false;

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

// Filtro por cantidad de víctimas
if (!empty($_GET['victims_number'])) {
    $victims_number = $conexion->real_escape_string($_GET['victims_number']);
    // $where[] = "v.name_victims LIKE '%$victim%'";
    // $useVictimsJoin = true;
    // $groupBy = false;
    $where[] = "ki.victims_number LIKE '%$victims_number%'";
}

// Filtro por época (inicio)
if (!empty($_GET['start_year'])) {
    $start = (int) $_GET['start_year'];
    if ($start >= 1800 && $start <= (int) date("Y")) {
        $where[] = "ki.period_start >= $start";
    }
}

// Filtro por época (fin)
if (!empty($_GET['end_year'])) {
    $end = (int) $_GET['end_year'];
    if ($end >= 1800 && $end <= (int) date("Y")) {
        $where[] = "ki.period_end <= $end";
    }
}

// Filtro por lugar del crimen
if (!empty($_GET['crime_place'])) {
    $lugar = $conexion->real_escape_string($_GET['crime_place']);
    if (!empty($_GET['name_victims'])) {
        $where[] = "v.crime_place = '$lugar'";
    } else {
        $where[] = "EXISTS (
            SELECT 1 FROM victims v2
            WHERE v2.killer_id = ki.id_killer AND v2.crime_place = '$lugar'
        )";
    }
    $useVictimsJoin = true;
}

// JOIN solo si se necesita acceder a victims directamente
if ($useVictimsJoin) {
    $joinVictims = "JOIN victims v ON v.killer_id = ki.id_killer";
}

// Armar la condición
$condition = "";
if (!empty($where)) {
    $condition = "WHERE " . implode(" AND ", $where);
}

// Consulta principal
$sql = "
SELECT ki.*
FROM killer_information ki
$joinVictims
$condition
";

if ($groupBy) {
    $sql .= " GROUP BY ki.id_killer";
}

// Ejecutar consulta
$result = $conexion->query($sql);

// Cargar lugares únicos
$lugares = [];
$lugaresQuery = "SELECT DISTINCT crime_place FROM victims WHERE crime_place IS NOT NULL AND crime_place != ''";
$lugaresResult = $conexion->query($lugaresQuery);

if ($lugaresResult) {
    while ($row = $lugaresResult->fetch_assoc()) {
        $lugares[] = $row['crime_place'];
    }
}

// Verificar resultados y generar mensajes por filtro
$filterDisabled = false;
$messages = [];

if ($result->num_rows == 0) {
    $filterDisabled = true;

    // Revisa qué filtros están activos y añade mensaje
    if (!empty($_GET['name_killer'])) {
        $messages[] = "No se encontraron asesinos con ese nombre.";
    }
    if (!empty($_GET['alias'])) {
        $messages[] = "No se encontraron asesinos con ese alias.";
    }
    if (!empty($_GET['victims_number'])) {
        $messages[] = "No se encontraron víctimas con ese nombre.";
    }
    if (!empty($_GET['crime_place'])) {
        $messages[] = "No hay asesinatos registrados en ese lugar.";
    }
    if (!empty($_GET['start_year']) || !empty($_GET['end_year'])) {
        $messages[] = "No se encontraron asesinos en esa época.";
    }

    // Si no se aplicó ningún filtro, mensaje genérico
    if (empty($_GET)) {
        $messages[] = "No hay datos disponibles.";
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- <link rel="stylesheet" href="css/slick.css" />
    <link rel="stylesheet" href="css/slick-theme.css" /> -->

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
            <div class="user" id="user">
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
                <form id="filterForm" method="GET" action="index.php#killersCarousel">
                    <!-- Nombre del asesino -->
                    <label>Nombre</label>
                    <input type="text" name="name_killer" placeholder="Buscar asesino" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                        title="Solo letras y espacios" value="<?= htmlspecialchars($_GET['alias'] ?? '') ?>" />

                    <!-- Alias -->
                    <label>Alias</label>
                    <input type="text" name="alias" placeholder="Buscar alias" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                        title="Solo letras y espacios" value="<?= htmlspecialchars($_GET['name_descrip_killer'] ?? '') ?>" />

                    <!-- Lugar de actividad -->
                    <label for="crime_place">Lugar de actividad</label>
                    <select name="crime_place" id="crime_place">
                        <option value="">-- Selecciona --</option>
                        <?php foreach ($lugares as $lugar): ?>
                            <option value="<?= htmlspecialchars($lugar) ?>" <?= isset($_GET['crime_place']) && $_GET['crime_place'] === $lugar ? 'selected' : '' ?>>
                                <?= htmlspecialchars($lugar) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Número de víctimas -->
                    <label>Víctimas</label>
                    <input type="number" name="victims_number" placeholder="Buscar por número de víctimas"
                        value="<?= htmlspecialchars($_GET['victims_number'] ?? '') ?>" />

                    <!-- Época -->
                    <label>Época de actividad</label>
                    <div class="date-range">
                        <input type="number" name="start_year" placeholder="Mín (ej. 1970)" min="1800" max="2025"
                            value="<?= htmlspecialchars($_GET['start_year'] ?? '') ?>" />
                        <input type="number" name="end_year" placeholder="Máx (ej. 1980)" min="1800" max="2025"
                            value="<?= htmlspecialchars($_GET['end_year'] ?? '') ?>" />
                    </div>

                    <?php if (!empty($messages)): ?>
                        <div style="color: red; margin-top: 10px;">
                            <?php foreach ($messages as $msg): ?>
                                <p><?= $msg ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>


                    <div class="btn_filter">
                        <a href="index.php#killersCarousel">Borrar</a>
                        <button type="submit" <?= $filterDisabled ? 'disabled' : '' ?>>Filtrar</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Ventana modal de suscripción -->
        <div id="subscribeModal" class="modal hidden">
            <div class="modal-content">
                <button class="close-btn" id="closeSubscribe">
                    <img src="./img/icons/close.png" alt="Cerrar" />
                </button>

                <h2 class="title_window">Suscríbete</h2>
                <form id="subscribeForm" method="POST" action="php/insertUser.php">
                    <!-- Nombre -->
                    <label>Nombre</label>
                    <input type="text" name="name" placeholder="Tu nombre"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Solo letras y espacios" required />

                    <!-- Apellido -->
                    <label>Apellido</label>
                    <input type="text" name="surname" placeholder="Tu apellido"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Solo letras y espacios" required />

                    <!-- Email -->
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Tu email" required />

                    <!-- Checkbox -->
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required />
                        Acepto los <a href="#">términos y condiciones</a>
                    </label>

                    <div class="btn_filter">
                        <button type="submit">Suscribirse</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="killersContainer" id="killersContainer">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="killer" onclick="location.href='detalle.php?id=<?= $row['id_killer'] ?>'" style="width:70%">
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

    <script src='js/myScript.js'></script>
    <script src='js/ventana_emergente.js'></script>

    <!-- CARRUSEL -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js" integrity="sha512-BzvgYEoHXuphX+g7B/laemJGYFdrq4fTKEo+B3PurSxstMZtwu28FHkPKXu6dSBCzbUWqz/rMv755nUwhjQypw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

    <!-- <script src="js/slick.js"></script> -->
    <!-- <script src="js/jquery-3.7.1.js"></script> -->
    <script src="js/mySlick.js"></script>


    <!-- FILTRO -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filterForm = document.getElementById("filterForm");
            const filterButton = filterForm.querySelector("button[type='submit']");
            const modal = document.getElementById("filterModal");

            <?php if ($filterDisabled): ?>
                // Deshabilitar botón para evitar clicks
                filterButton.disabled = true;

                // Asegurar que el modal está visible
                modal.classList.remove("hidden");
            <?php endif; ?>
        });
    </script>
</body>

</html>