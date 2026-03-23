<?php
include("conection.php");

$id = $_POST['id'];
$name = $_POST['name'];
$type = $_POST['type'];
$price = $_POST['price'];
$proveedor_id = $_POST['proveedor_id'];

$sql = "UPDATE alimentos 
SET name='$name',
type='$type',
price='$price',
proveedor_id='$proveedor_id'
WHERE id='$id'";

echo $conexion->query($sql) ? "ok" : "error";

$conexion->close();
?>