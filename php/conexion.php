<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar la sesión solo si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "injury";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
