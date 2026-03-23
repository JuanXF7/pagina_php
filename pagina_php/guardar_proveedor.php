<?php

$conn = new mysqli("mysql","usuario_alimentos","123456",database: "alimentos_db");

$name = $_POST['name'];
$company = $_POST['company'];
$phone = $_POST['phone'];

$sql = "INSERT INTO proveedores(name,company,phone)
VALUES('$name','$company','$phone')";

if($conn->query($sql)){
    echo "ok";
}
?>