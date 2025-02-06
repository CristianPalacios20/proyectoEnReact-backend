<?php

//api/login.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

require_once 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

// Imprimir datos para depuración
error_log('Cuerpo de la solicitud: ' . file_get_contents("php://input"));


if (!isset($data['correo']) || !isset($data['contrasena'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos en la solicitud.'
    ]);
    exit();
}

$correo = $data['correo'];
$contrasena = $data['contrasena'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    // error_log('Contraseña recibida: ' . $contrasena);
    // error_log('Hash almacenado: ' . $usuario['contrasena']);

    if(password_verify($contrasena, $usuario['contrasena'])){
        $_SESSION['nombres'] = $usuario['nombres'];
        echo json_encode([ 
            'success' => true,
            'message' => 'Inicio de sesión correcto',
            'usuario' => $usuario // Incluye toda la información del usuario
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'message' => '¡Usuario y/o contraseña incorrectos!'
        ]);
    }
}else{
    echo json_encode([
        'success' => false,
        'message' => '¡Usuario y/o contraseña incorrectos!'
    ]);
}

$stmt->close();
$conn->close();

?>