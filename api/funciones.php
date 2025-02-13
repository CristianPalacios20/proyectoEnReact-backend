<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'conexion.php';

$sql = " SELECT 
        (SELECT SUM(cantidad) FROM productos) AS totalCantidad,
        (SELECT COUNT(*) FROM productos WHERE estado_id = 1) AS productosActivos,
        (SELECT COUNT(*) FROM productos WHERE estado_id = 2) AS productosInactivos
        -- (SELECT COUNT(*) FROM productos WHERE cantidad = 0) AS productosSinStock,
        -- (SELECT nombre FROM productos ORDER BY ventas DESC LIMIT 1) AS productosMasVendido,
        -- (SELECT nombre FROM productos ORDER BY ventas ASC LIMIT 1) AS productosMenosVendido
        ";
$result = $conn->query($sql);
$metricas = [
    "TP" => 0,
    "PA" => 0,
    "PI" => 0,
    "PMV_positivo" => 0,
    "PMV_negativo" => 0
];

if($result && $row = $result->fetch_assoc()) {
    $metricas["TP"] = (int) $row["totalCantidad"];
    $metricas["PA"] = (int) $row["productosActivos"];
    $metricas["PI"] = (int) $row["productosInactivos"];
    // $metricas["PMV+"] = (int) $row["productosMasVendido"];
    // $metricas["PMV-"] = (int) $row["productosMenosVendido"];
}

echo json_encode($metricas);

?>