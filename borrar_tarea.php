<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    include_once '../includes/conexion.php';
    
    $taskId = $_POST['id'];
    $usuario = $_SESSION['usuario'];
    
    // Consulta SQL para borrar la tarea
    $sql = "DELETE FROM tareas WHERE id='$taskId' AND usuario='$usuario'";
    
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
    }
    
    mysqli_close($conexion);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
