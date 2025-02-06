<?php 
// api/registro.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'conexion.php';

//obtener los datos del cuerpo de la solicitud
$data = json_decode( file_get_contents("php://input"), true);
// var_dump($data);
// exit;

if(!$data){
    echo json_encode([
        'success' => false,
        'message' => 'Datos no recibidos correctamente',
        'raw_input' => file_get_contents("php://input"), 
    ]);
    exit;
}

$registroNombres = $data['nombres'];
$registroApellidos = $data['apellidos'];
$registroCorreo = $data['correo'];
$registroContrasena = $data['contrasena'];
$registroRolId = $data['rol_id'];

//encriptar la contraseña
$hashedPassword = password_hash($registroContrasena, PASSWORD_DEFAULT);

$stmCheck = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
$stmCheck -> bind_param("s", $registroCorreo);
$stmCheck -> execute();
$resultCheck = $stmCheck->get_result();

if($resultCheck->num_rows > 0){
    echo json_encode([
        'success' => false,
        'message' => '¡El correo ya está registrado!'
    ]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO usuarios (nombres, apellidos, correo, contrasena, rol_id) VALUES (?, ?, ?, ?, ?)");
$stmt -> bind_param(
    "ssssi", 
    $registroNombres, 
    $registroApellidos, 
    $registroCorreo, 
    $hashedPassword, 
    $registroRolId
);

if($stmt->execute()){
    echo json_encode([
        'success' => true,
        'message' => 'Usuario registrado correctamente'
    ]);
}else{
    echo json_encode([
        'success' => false,
        'message' => 'Error al registrar el usuario: '. $stmt->error
    ]);
}

$stmt->close();
$conn->close();

?>