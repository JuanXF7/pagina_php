<?php

$conn = new mysqli("mysql", "usuario_alimentos", "123456", "alimentos_db");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/* =========================
   TOTAL ALIMENTOS
========================= */

$totalAlimentos = $conn->query("SELECT COUNT(*) as total FROM alimentos")
    ->fetch_assoc()["total"];


/* =========================
   TOTAL PROVEEDORES
========================= */

$totalProveedores = $conn->query("SELECT COUNT(*) as total FROM proveedores")
    ->fetch_assoc()["total"];


/* =========================
   PRECIO PROMEDIO
========================= */

$precioPromedio = $conn->query("SELECT AVG(price) as promedio FROM alimentos")
    ->fetch_assoc()["promedio"];


/* =========================
   ALIMENTOS POR TIPO
========================= */

$sqlTipos = "
SELECT type, COUNT(*) as total
FROM alimentos
GROUP BY type
";

$resultTipos = $conn->query($sqlTipos);

$porTipo = [];

while ($row = $resultTipos->fetch_assoc()) {
    $porTipo[] = $row;
}


/* =========================
   PRODUCTOS POR PROVEEDOR
========================= */

$sqlProveedor = "
SELECT 
proveedores.company,
COUNT(alimentos.id) as total
FROM proveedores
LEFT JOIN alimentos
ON alimentos.proveedor_id = proveedores.id
GROUP BY proveedores.company
ORDER BY total DESC
";

$resultProveedor = $conn->query($sqlProveedor);

$porProveedor = [];

while ($row = $resultProveedor->fetch_assoc()) {
    $porProveedor[] = $row;
}


/* =========================
   RESPUESTA FINAL
========================= */

echo json_encode([
    "totalAlimentos" => $totalAlimentos,
    "totalProveedores" => $totalProveedores,
    "precioPromedio" => $precioPromedio,
    "porTipo" => $porTipo,
    "porProveedor" => $porProveedor
]);

?>