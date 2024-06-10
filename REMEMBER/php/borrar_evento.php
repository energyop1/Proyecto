<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión

include_once '../includes/conexion.php'; // Incluye el archivo de conexión a la base de datos

// Verifica si no se ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No se ha iniciado sesión.']);
    exit; // Finaliza la ejecución del script
}

// Verifica si se ha enviado el ID del evento por método POST
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Obtiene el ID del evento desde la solicitud POST
    $usuario = $_SESSION['usuario']; // Obtiene el usuario de la sesión actual

    // Sentencia SQL para eliminar el evento con el ID proporcionado y asociado al usuario actual
    $sql = "DELETE FROM eventos WHERE id='$id' AND usuario='$usuario'";
    
    // Ejecuta la consulta SQL
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['success' => true]); // Devuelve una respuesta JSON de éxito si la consulta se ejecuta correctamente
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el evento.']); // Devuelve una respuesta JSON de error si la consulta falla
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de evento no proporcionado.']); // Devuelve una respuesta JSON de error si no se proporciona el ID del evento
}
?>

