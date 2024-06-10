<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location:  ../pages/index.php");
    exit;
}

include_once '../includes/conexion.php';

// Verificar si se enviaron los datos necesarios del formulario
if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['dia_inicio'], $_POST['dia_final'], $_POST['color'])) {
    $usuario = $_SESSION['usuario'];
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $dia_inicio = mysqli_real_escape_string($conexion, $_POST['dia_inicio']);
    $dia_final = mysqli_real_escape_string($conexion, $_POST['dia_final']);
    $color = mysqli_real_escape_string($conexion, $_POST['color']); // Nuevo campo: color

    // Validar que las fechas no sean menores al año 2024
    if (strtotime($dia_inicio) < strtotime('2024-01-01') || strtotime($dia_final) < strtotime('2024-01-01')) {
        echo "Las fechas del evento no pueden ser anteriores al año 2024.";
        exit;
    }

    // Validar que la fecha final no sea anterior a la fecha de inicio
    if (strtotime($dia_final) < strtotime($dia_inicio)) {
        echo "El día final no puede ser anterior al día de inicio.";
        exit;
    }

    // Insertar el evento en la base de datos
    $sql = "INSERT INTO eventos (nombre, descripcion, dia_inicio, dia_final, color, usuario) VALUES ('$nombre', '$descripcion', '$dia_inicio', '$dia_final', '$color', '$usuario')";
    
    if (mysqli_query($conexion, $sql)) {
        // Redirigir a la página de bienvenida después de la inserción exitosa
        header("Location:  ../pages/bienvenido.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
} else {
    echo "Todos los campos son obligatorios.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
