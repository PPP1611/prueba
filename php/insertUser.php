<?php
// 1. Incluir la conexión a la base de datos
include_once 'conexion.php';

// 2. Recibir y limpiar los datos del formulario
$name = trim($_POST['name']);
<<<<<<< HEAD
$surname = trim($_POST['surname']);
$email = trim($_POST['email']);

// 3. Validación básica
if (empty($name) || empty($surname) || empty($email)) {
=======
$email = trim($_POST['email']);

// 3. Validación básica
if (empty($name) || empty($email)) {
>>>>>>> cd81d813cad284093c85bd546c41e2fdcd3264d3
    die('Todos los campos son obligatorios.');
}

// 4. Preparar la consulta SQL de forma segura
<<<<<<< HEAD
$stmt = $conexion->prepare("INSERT INTO user (name_user, surname, email_user) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name,  $surname,$email);
=======
$stmt = $conexion->prepare("INSERT INTO user (name_user, email_user) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);
>>>>>>> cd81d813cad284093c85bd546c41e2fdcd3264d3

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


