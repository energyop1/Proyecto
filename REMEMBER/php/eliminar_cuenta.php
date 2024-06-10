<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../php/index.php");
    exit;
}

include_once '../includes/conexion.php';

$usuario = $_SESSION['usuario'];

// Eliminar la cuenta del usuario
$sql = "DELETE FROM usuarios WHERE usuario='$usuario'";

if (mysqli_query($conexion, $sql)) {
    // Cerrar sesión y redirigir al inicio
    session_destroy();
    header("Location: ../pages/index.php");
    exit;
} else {
    echo "Error al eliminar la cuenta.";
}

mysqli_close($conexion);
?>
