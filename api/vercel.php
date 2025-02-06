<?php

require "conexion.php";

if ($conn->ping()) {
    echo json_encode(["success" => true, "message" => "Conexión exitosa desde Vercel"]);
} else {
    echo json_encode(["success" => false, "message" => "Error en la conexión"]);
}

?>