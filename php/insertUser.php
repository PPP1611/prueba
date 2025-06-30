<?php
include_once 'conexion.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);

if (empty($name) || empty($email)) {
    die('Todos los campos son obligatorios.');
}

$stmt = $conexion->prepare("INSERT INTO user (name_user, email_user) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);

if ($stmt->execute()) {
    header("Location: ../index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
