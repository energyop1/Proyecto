<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es el administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'Administrador') {
    header("Location: index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include_once '../includes/conexion.php';

// Manejar eliminación de usuario
if (isset($_POST['eliminar'])) {
    $usuarioAEliminar = $_POST['usuario'];
    $sql = "DELETE FROM usuarios WHERE usuario='$usuarioAEliminar'";
    mysqli_query($conexion, $sql);
}

// Manejar búsqueda de usuario
$buscarUsuario = '';
if (isset($_POST['buscar'])) {
    $buscarUsuario = $_POST['buscar_usuario'];
}

$sql = "SELECT * FROM usuarios WHERE usuario LIKE '%$buscarUsuario%'";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/administrador.css">
</head>
<body>
<div class="logout-btn">
        <a href="../includes/cerrar_sesion.php">Cerrar sesión</a>
    </div>
    <h2>Administrador</h2>
    
    <form method="post">
        <input type="text" name="buscar_usuario" placeholder="Buscar usuario" value="<?php echo $buscarUsuario; ?>">
        <input type="submit" name="buscar" value="Buscar">
    </form>

    <div class="card-container">
        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
        <div class="card">
            <h3><?php echo $fila['usuario']; ?></h3>
            <p><?php echo $fila['email']; ?></p>
            <a class="ver-detalles" href="detalles_usuario.php?id=<?php echo $fila['id']; ?>">Ver detalles</a>
            <form method="post">
                <input type="hidden" name="usuario" value="<?php echo $fila['usuario']; ?>">
                <input type="submit" name="eliminar" value="Eliminar">
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>
