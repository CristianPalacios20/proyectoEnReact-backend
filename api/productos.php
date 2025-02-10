<?php
 //table productos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'conexion.php';

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

$productos = [];

if($result->num_rows > 0){
    while($fila = $result->fetch_assoc()){
        $productos[] = $fila;
    }
}

echo json_encode($productos);

?>