<?php

$conn = new mysqli("mysql","usuario_alimentos","123456",database: "alimentos_db");

$id = $_POST['id'];

$sql = "DELETE FROM proveedores WHERE id=$id";

if($conn->query($sql)){
    echo "ok";
}
?>