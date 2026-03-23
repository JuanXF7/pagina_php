<?php
include("conection.php");

$limite = 7;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";

$inicio = ($pagina - 1) * $limite;

/* =========================
   FILTRO BUSQUEDA
========================= */

$where = "";

if($busqueda != ""){
    $busqueda = $conexion->real_escape_string($busqueda);

    $where = "WHERE alimentos.name LIKE '%$busqueda%' 
              OR alimentos.type LIKE '%$busqueda%'";
}

/* =========================
   TOTAL REGISTROS
========================= */

$totalQuery = $conexion->query("
SELECT COUNT(*) as total 
FROM alimentos
$where
");

$totalRow = $totalQuery->fetch_assoc();
$totalRegistros = $totalRow['total'];
$totalPaginas = ceil($totalRegistros / $limite);

/* =========================
   CONSULTA PRINCIPAL
========================= */

$sql = "
SELECT 
alimentos.id,
alimentos.name,
alimentos.type,
alimentos.price,
proveedores.company
FROM alimentos
LEFT JOIN proveedores
ON alimentos.proveedor_id = proveedores.id
$where
ORDER BY alimentos.id ASC
LIMIT $inicio,$limite
";

$resultado = $conexion->query($sql);

$datos = [];

while($fila = $resultado->fetch_assoc()){

    // Si no tiene proveedor
    if($fila['company'] == null){
        $fila['company'] = "Sin proveedor";
    }

    $datos[] = $fila;
}

echo json_encode([
    "datos" => $datos,
    "totalPaginas" => $totalPaginas
]);

$conexion->close();
?>