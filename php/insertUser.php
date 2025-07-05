<?php
// 1. Incluir la conexión a la base de datos
include_once 'conexion.php';

// 2. Recibir y limpiar los datos del formulario
$name = trim($_POST['name']);
$email = trim($_POST['email']);

// 3. Validación básica
if (empty($name) || empty($email)) {
    die('Todos los campos son obligatorios.');
}

// 4. Preparar la consulta SQL de forma segura
$stmt = $conexion->prepare("INSERT INTO user (name_user, email_user) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);

// 5. Ejecutar la consulta y redirigir
if ($stmt->execute()) {
    // Si la inserción fue exitosa, redirige al usuario a la página principal
    header("Location: ../index.php");
    exit();
} else {
    // Si hubo un error, muestra el mensaje de error
    echo "Error: " . $stmt->error;
}

// 6. Cerrar recursos
$stmt->close();
$conexion->close();


