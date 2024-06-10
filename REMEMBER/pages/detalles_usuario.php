<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es el administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'Administrador') {
    header("Location: index.php");
    exit();
}

// Verificar si se proporcionó un ID de usuario válido en la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: administrador.php");
    exit();
}

// Obtener el ID de usuario de la URL
$usuario_id = $_GET['id'];

// Incluir el archivo de conexión a la base de datos
include_once '../includes/conexion.php';

// Obtener información del usuario
$sql_usuario = "SELECT * FROM usuarios WHERE id = $usuario_id";
$resultado_usuario = mysqli_query($conexion, $sql_usuario);
$usuario = mysqli_fetch_assoc($resultado_usuario);

// Obtener las tareas del usuario
$sql_tareas = "SELECT * FROM tareas WHERE usuario = '{$usuario['usuario']}'";
$resultado_tareas = mysqli_query($conexion, $sql_tareas);

// Obtener los eventos del usuario
$sql_eventos = "SELECT * FROM eventos WHERE usuario = '{$usuario['usuario']}'";
$resultado_eventos = mysqli_query($conexion, $sql_eventos);

// Manejar eliminación de tarea
if (isset($_POST['eliminar_tarea'])) {
    $tarea_id = $_POST['eliminar_tarea'];
    // Ejecutar la consulta para eliminar la tarea con el ID especificado
    $sql = "DELETE FROM tareas WHERE id='$tarea_id' AND usuario='{$usuario['usuario']}'";
    mysqli_query($conexion, $sql);
    // Redirigir o refrescar la página
    header("Location: detalles_usuario.php?id=$usuario_id");
    exit();
}

// Manejar eliminación de evento
if (isset($_POST['eliminar_evento'])) {
    $evento_id = $_POST['eliminar_evento'];
    // Ejecutar la consulta para eliminar el evento con el ID especificado
    $sql_eliminar_evento = "DELETE FROM eventos WHERE id = $evento_id";
    mysqli_query($conexion, $sql_eliminar_evento);
    // Redirigir o refrescar la página
    header("Location: detalles_usuario.php?id=$usuario_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
    <link rel="stylesheet" href="../css/detalles_usuario.css">
</head>
<body>
<button class="back-button" onclick="window.history.back()">Volver atrás</button>

<h2>Detalles del Usuario: <?php echo $usuario['usuario']; ?></h2>

<h3>Tareas:</h3>
<div class="card-container">
    <?php while ($tarea = mysqli_fetch_assoc($resultado_tareas)) { ?>
        <div class="card">
            <h3><?php echo $tarea['titulo']; ?></h3>
            <p><?php echo $tarea['descripcion']; ?></p>
            <p><strong>Fecha de creación:</strong> <?php echo $tarea['fecha_creacion']; ?></p>
            <p><strong>Día límite:</strong> <?php echo $tarea['dia_limite']; ?></p>
            <p><strong>Nivel de urgencia:</strong> <?php echo $tarea['nivel_urgencia']; ?></p>
            <form method="post">
                <input type="hidden" name="eliminar_tarea" value="<?php echo $tarea['id']; ?>">
                <input type="submit" value="Eliminar tarea">
            </form>
        </div>
    <?php } ?>
</div>

<h3>Eventos:</h3>
<div class="card-container">
    <?php while ($evento = mysqli_fetch_assoc($resultado_eventos)) { ?>
        <div class="card">
            <h3><?php echo $evento['nombre']; ?></h3>
            <p><?php echo $evento['descripcion']; ?></p>
            <p><strong>Día de inicio:</strong> <?php echo $evento['dia_inicio']; ?></p>
            <p><strong>Día final:</strong> <?php echo $evento['dia_final']; ?></p>
            <form method="post">
                <input type="hidden" name="eliminar_evento" value="<?php echo $evento['id']; ?>">
                <input type="submit" value="Eliminar evento">
            </form>
        </div>
    <?php } ?>
</div>
</body>
</html>
