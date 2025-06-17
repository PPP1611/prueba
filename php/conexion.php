<?php
$host = "localhost";
$user = "root";
$password = "";       
$db = "injury"; 

$conexion = new mysqli($host, $user, $password, $db);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
