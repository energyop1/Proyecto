<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Verificar si el formulario de creación de tarea fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once '../includes/conexion.php';
    
    // Obtener los datos del formulario de creación de tarea
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $dia_limite = mysqli_real_escape_string($conexion, $_POST['dia_limite']);
    $nivel_urgencia = mysqli_real_escape_string($conexion, $_POST['nivel_urgencia']);
    $color = mysqli_real_escape_string($conexion, $_POST['color']); // Nuevo campo: color
    $usuario = $_SESSION['usuario'];

    // Consulta SQL para insertar una nueva tarea en la base de datos
    $sql = "INSERT INTO tareas (usuario, titulo, descripcion, dia_limite, nivel_urgencia, color) 
            VALUES ('$usuario', '$titulo', '$descripcion', '$dia_limite', '$nivel_urgencia', '$color')";
    
    if (mysqli_query($conexion, $sql)) {
        // Tarea creada exitosamente, redirigir al usuario a la página de bienvenida
        header("Location: bienvenido.php");
        exit;
    } else {
        // Si hay un error en la inserción, mostrar mensaje de error
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
    
    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
}
?>
