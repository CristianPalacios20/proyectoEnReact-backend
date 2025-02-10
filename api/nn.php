<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Verificar que la solicitud sea del tipo DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    // Obtener los datos enviados en la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si se ha recibido un ID válido
    if (isset($data['id'])) {
        $id = $data['id'];

        // Crear la consulta SQL para eliminar el producto
        $sql = "DELETE FROM productos WHERE id = ?";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular el parámetro (el ID)
            $stmt->bind_param("i", $id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Si la eliminación fue exitosa, devolver una respuesta JSON de éxito
                echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente.']);
            } else {
                // Si hubo un error al ejecutar la consulta
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto.']);
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Si hubo un error preparando la consulta
            echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta.']);
        }

    } else {
        // Si no se recibe un ID en la solicitud
        echo json_encode(['success' => false, 'message' => 'No se proporcionó un ID válido.']);
    }

} else {
    // Si la solicitud no es del tipo DELETE
    echo json_encode(['success' => false, 'message' => 'Método no permitido. Solo se permite el método DELETE.']);
}

// Cerrar la conexión
$conn->close();
?>
