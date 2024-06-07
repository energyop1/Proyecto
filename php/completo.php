<?php
session_start();

include_once '../includes/conexion.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $id = $_POST['id'];
    $usuario = $_SESSION['usuario'];

    if ($tipo == 'tarea') {
        $sql = "INSERT INTO tareas_hechas (usuario, tarea_id) VALUES ('$usuario', '$id')";
        if (mysqli_query($conexion, $sql)) {
            $response['success'] = true;
        } else {
            $response['message'] = 'Error al marcar la tarea como completada.';
        }
    } elseif ($tipo == 'evento') {
        $sql = "INSERT INTO eventos_hechos (usuario, evento_id) VALUES ('$usuario', '$id')";
        if (mysqli_query($conexion, $sql)) {
            $response['success'] = true;
        } else {
            $response['message'] = 'Error al marcar el evento como completado.';
        }
    }
}

mysqli_close($conexion);
echo json_encode($response);
?>
