<?php

$conn = new mysqli("mysql","usuario_alimentos","123456","alimentos_db");

$result = $conn->query("SELECT id, company FROM proveedores");

$datos = [];

while($row = $result->fetch_assoc()){
    $datos[] = $row;
}

echo json_encode($datos);
?>