<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
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

    // Insertar el evento en la base de datos
    $sql = "INSERT INTO eventos (nombre, descripcion, dia_inicio, dia_final, color, usuario) VALUES ('$nombre', '$descripcion', '$dia_inicio', '$dia_final', '$color', '$usuario')";
    
    if (mysqli_query($conexion, $sql)) {
        // Redirigir a la página de bienvenida después de la inserción exitosa
        header("Location: bienvenido.php");
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
