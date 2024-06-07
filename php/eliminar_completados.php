<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location:  ../pages/index.php");
    exit;
}

include_once '../includes/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tarea_id'])) {
        // Eliminar tarea completada
        $tarea_id = $_POST['tarea_id'];
        $usuario = $_SESSION['usuario'];

        $sql = "DELETE FROM tareas_hechas WHERE usuario='$usuario' AND tarea_id='$tarea_id'";
        
        if (mysqli_query($conexion, $sql)) {
            header("Location:  ../pages/editar_usuario.php");
            exit;
        } else {
            echo "Error al eliminar la tarea completada.";
            exit;
        }
    } elseif (isset($_POST['evento_id'])) {
        // Eliminar evento completado
        $evento_id = $_POST['evento_id'];
        $usuario = $_SESSION['usuario'];

        $sql = "DELETE FROM eventos_hechos WHERE usuario='$usuario' AND evento_id='$evento_id'";
        
        if (mysqli_query($conexion, $sql)) {
            header("Location: ../pages/editar_usuario.php");
            exit;
        } else {
            echo "Error al eliminar el evento completado.";
            exit;
        }
    } else {
        echo "Error: No se pudo identificar qué eliminar.";
        exit;
    }
}

mysqli_close($conexion);
?>
