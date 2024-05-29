<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

include_once '../includes/conexion.php';

// Obtener el filtro de la solicitud GET
$filtro = $_GET['filtro'];

// Consulta SQL para obtener las tareas según el filtro
$usuario = $_SESSION['usuario'];
if ($filtro === 'fecha') {
    $sql = "SELECT * FROM tareas WHERE usuario='$usuario' AND id NOT IN (SELECT tarea_id FROM tareas_hechas WHERE usuario='$usuario') ORDER BY dia_limite DESC";
} elseif ($filtro === 'urgencia') {
    $sql = "SELECT * FROM tareas WHERE usuario='$usuario' AND id NOT IN (SELECT tarea_id FROM tareas_hechas WHERE usuario='$usuario') ORDER BY nivel_urgencia DESC";
} else {
    // Si el filtro no es válido, cargar todas las tareas por defecto
    $sql = "SELECT * FROM tareas WHERE usuario='$usuario' AND id NOT IN (SELECT tarea_id FROM tareas_hechas WHERE usuario='$usuario')";
}

$resultado = mysqli_query($conexion, $sql);

// Array para almacenar las tareas
$tareas = array();
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $tareas[] = $fila;
    }
}

// Devolver las tareas en formato JSON
echo json_encode($tareas);
?>
