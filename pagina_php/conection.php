<?php

$host = "mysql";
$user = "usuario_alimentos";
$password = "123456";
$db = "alimentos_db";

$conexion = new mysqli($host, $user, $password, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>