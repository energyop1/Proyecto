<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión

if (!isset($_SESSION['usuario'])) { // Verifica si el usuario ha iniciado sesión
    header("Location:  ../pages/index.php"); // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    exit;
}

include_once '../includes/conexion.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica si la solicitud es de tipo POST
    if (isset($_POST['tarea_id'])) { // Verifica si se ha enviado el ID de la tarea a eliminar
        // Eliminar tarea completada
        $tarea_id = $_POST['tarea_id']; // Obtiene el ID de la tarea a eliminar
        $usuario = $_SESSION['usuario']; // Obtiene el usuario de la sesión actual

        $sql = "DELETE FROM tareas_hechas WHERE usuario='$usuario' AND tarea_id='$tarea_id'"; // Consulta para eliminar la tarea completada
        
        if (mysqli_query($conexion, $sql)) { // Ejecuta la consulta SQL y verifica si se ejecuta correctamente
            header("Location:  ../pages/editar_usuario.php"); // Redirige al usuario a la página de edición de usuario después de eliminar la tarea
            exit;
        } else {
            echo "Error al eliminar la tarea completada."; // Muestra un mensaje de error si la consulta falla
            exit;
        }
    } elseif (isset($_POST['evento_id'])) { // Verifica si se ha enviado el ID del evento a eliminar
        // Eliminar evento completado
        $evento_id = $_POST['evento_id']; // Obtiene el ID del evento a eliminar
        $usuario = $_SESSION['usuario']; // Obtiene el usuario de la sesión actual

        $sql = "DELETE FROM eventos_hechos WHERE usuario='$usuario' AND evento_id='$evento_id'"; // Consulta para eliminar el evento completado
        
        if (mysqli_query($conexion, $sql)) { // Ejecuta la consulta SQL y verifica si se ejecuta correctamente
            header("Location: ../pages/editar_usuario.php"); // Redirige al usuario a la página de edición de usuario después de eliminar el evento
            exit;
        } else {
            echo "Error al eliminar el evento completado."; // Muestra un mensaje de error si la consulta falla
            exit;
        }
    } else {
        echo "Error: No se pudo identificar qué eliminar."; // Muestra un mensaje de error si no se puede identificar qué eliminar
        exit;
    }
}

mysqli_close($conexion); // Cierra la conexión a la base de datos
?>

