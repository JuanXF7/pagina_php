<?php
include("conection.php");

$name = $_POST['name'];
$type = $_POST['type'];
$price = $_POST['price'];
$proveedor_id = $_POST['proveedor_id'];

$sql = "INSERT INTO alimentos (name, type, price,proveedor_id)
        VALUES ('$name','$type','$price','$proveedor_id')";

echo $conexion->query($sql) ? "ok" : "error";

$proveedor_id = $_POST['proveedor_id'];

$sql = "INSERT INTO alimentos(name,type,price,proveedor_id)
VALUES('$name','$type','$price','$proveedor_id')";

$conexion->close();
?>