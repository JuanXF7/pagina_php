<?php

$conn = new mysqli("mysql","usuario_alimentos","123456",database: "alimentos_db");

$id = $_POST['id'];
$name = $_POST['name'];
$company = $_POST['company'];
$phone = $_POST['phone'];

$sql = "UPDATE proveedores 
SET name='$name', company='$company', phone='$phone'
WHERE id=$id";

if($conn->query($sql)){
    echo "ok";
}
?>