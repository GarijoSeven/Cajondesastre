<?php

$host = "localhost";
$usuario = "u693571033_seven";
$contrasena = "@Garijo9596";
$base_datos = "u693571033_cajondesastre";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
