<?php

$conn = new mysqli("mysql","usuario_alimentos","123456",database: "alimentos_db");

if($conn->connect_error){
    die("Error conexion");
}

$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";

$limite = 7;
$inicio = ($pagina - 1) * $limite;

$where = "";

if($busqueda != ""){
    $where = "WHERE name LIKE '%$busqueda%'";
}

$sql = "SELECT * FROM proveedores $where LIMIT $inicio,$limite";

$result = $conn->query($sql);

$datos = [];

while($row = $result->fetch_assoc()){
    $datos[] = $row;
}

$total = $conn->query("SELECT COUNT(*) as total FROM proveedores $where");
$total = $total->fetch_assoc()['total'];

$totalPaginas = ceil($total / $limite);

echo json_encode([
    "datos"=>$datos,
    "totalPaginas"=>$totalPaginas
]);
?>