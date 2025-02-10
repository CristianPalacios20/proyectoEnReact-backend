<?php
// api/conexion.php
// Cargar variables de entorno si existe un archivo .env (para entornos locales)
if (file_exists(__DIR__ . "../.env")) {
    $env = parse_ini_file(__DIR__ . "../.env");
    $_ENV = array_merge($_ENV, $env);
}
// Configuración de conexión segura
$servername = "34.55.220.177"; 
$username   = "root";
$password   = "2008";
$dbname     = "portafolio_csp";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Error en la conexión a MySQL en Google Cloud'
    ]);
} 

$conn->set_charset("utf8mb4");

?>

