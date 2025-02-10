<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json"); 

    require_once 'conexion.php';

    if($_SERVER["REQUEST_METHOD"] === "DELETE"){
        $data = json_decode(file_get_contents("php://input"), true);
        
        if(isset($data['id'])){
            $id = (int) ($data['id']);

            $sql = "DELETE FROM productos WHERE id = ?";

            if($stmt = $conn->prepare($sql)){
                $stmt->bind_param('i', $id);
                if($stmt->execute()){
                    echo json_encode(['success' => true,  'message' => 'Producto eliminado exitosamente']);
                }else{
                    echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto']);
                }

                $stmt->close();
            }else {
                // Si hubo un error preparando la consulta
                echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta.']);
            }
            
        }else {
            // Si no se recibe un ID en la solicitud
            echo json_encode(['success' => false, 'message' => 'No se proporcionó un ID válido.']);
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    }

    $conn->close();
?>