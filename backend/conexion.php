<?php

$servidor = "localhost";
$usuario = "u693571033_seven";
$password = "@Garijo9596";
$database = "u693571033_cajondesastre";

$conn = new mysqli($servidor, $usuario, $password, $database);

if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}


?>
