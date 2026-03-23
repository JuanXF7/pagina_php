<?php
include("conection.php");

$id = $_POST['id'];

$sql = "DELETE FROM alimentos WHERE id='$id'";

echo $conexion->query($sql) ? "ok" : "error";

$conexion->close();
?>