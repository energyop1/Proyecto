<?php
// Verificar si se recibió un ID de tarea válido
if (isset($_POST['id'])) {
    // Incluir el archivo de conexión a la base de datos
    include_once '../includes/conexion.php';

    // Obtener el ID de la tarea a borrar
    $id = $_POST['id'];

    // Consulta SQL para borrar la tarea de la base de datos
    $sql = "DELETE FROM tareas WHERE id = $id";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $sql)) {
        // Si la tarea se borró correctamente, devolver una respuesta JSON con éxito
        echo json_encode(['success' => true]);
    } else {
        // Si hubo un error al borrar la tarea, devolver una respuesta JSON con error
        echo json_encode(['success' => false]);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se recibió un ID de tarea válido, devolver una respuesta JSON con error
    echo json_encode(['success' => false]);
}
?>
