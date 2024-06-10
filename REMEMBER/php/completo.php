<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión

include_once '../includes/conexion.php'; // Incluye el archivo de conexión a la base de datos

$response = array('success' => false, 'message' => ''); // Inicializa una respuesta predeterminada

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Verifica si la solicitud es de tipo POST
    $tipo = $_POST['tipo']; // Obtiene el tipo de elemento (tarea o evento)
    $id = $_POST['id']; // Obtiene el ID del elemento a marcar como completado
    $usuario = $_SESSION['usuario']; // Obtiene el usuario de la sesión actual

    // Verifica el tipo de elemento y construye la consulta SQL correspondiente
    if ($tipo == 'tarea') {
        $sql = "INSERT INTO tareas_hechas (usuario, tarea_id) VALUES ('$usuario', '$id')"; // Consulta para marcar la tarea como completada
        // Ejecuta la consulta SQL y actualiza la respuesta en caso de éxito o error
        if (mysqli_query($conexion, $sql)) {
            $response['success'] = true; // Establece el éxito en true si la consulta se ejecuta correctamente
        } else {
            $response['message'] = 'Error al marcar la tarea como completada.'; // Establece un mensaje de error si la consulta falla
        }
    } elseif ($tipo == 'evento') {
        $sql = "INSERT INTO eventos_hechos (usuario, evento_id) VALUES ('$usuario', '$id')"; // Consulta para marcar el evento como completado
        // Ejecuta la consulta SQL y actualiza la respuesta en caso de éxito o error
        if (mysqli_query($conexion, $sql)) {
            $response['success'] = true; // Establece el éxito en true si la consulta se ejecuta correctamente
        } else {
            $response['message'] = 'Error al marcar el evento como completado.'; // Establece un mensaje de error si la consulta falla
        }
    }
}

mysqli_close($conexion); // Cierra la conexión a la base de datos
echo json_encode($response); // Devuelve la respuesta en formato JSON
?>
