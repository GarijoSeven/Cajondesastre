<?php

$servidor = "localhost";
$usuario = "u693571033_seven";
$password = "@Garijo9596";
$database = "u693571033_cajondesastre";

$conexion = new mysqli($servidor, $usuario, $password, $database);

if ($conexion->connect_error) {
    die("La conexion ha fallado: " . $conexion->connect_error);

}

$conexion->close();

?>