<?php
session_start();

include_once '../includes/conexion.php';

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No se ha iniciado sesión.']);
    exit;
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $usuario = $_SESSION['usuario'];

    $sql = "DELETE FROM eventos WHERE id='$id' AND usuario='$usuario'";
    
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el evento.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de evento no proporcionado.']);
}
?>
