<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../php/index.php");
    exit;
}

include_once '../includes/conexion.php';

// Obtener la información del usuario
$usuario = $_SESSION['usuario'];
$sql = "SELECT email, contraseña FROM usuarios WHERE usuario='$usuario'";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $email = $fila['email'];
    $contraseña_actual_hash = $fila['contraseña'];
} else {
    echo "Error: No se pudo obtener la información del usuario.";
    exit;
}

// Obtener las tareas completadas del usuario
$sqlTareasCompletadas = "SELECT t.id, t.titulo, th.fecha_completado FROM tareas t 
                         JOIN tareas_hechas th ON t.id = th.tarea_id 
                         WHERE th.usuario='$usuario'";
$resultadoTareasCompletadas = mysqli_query($conexion, $sqlTareasCompletadas);
$tareasCompletadas = array();

if (mysqli_num_rows($resultadoTareasCompletadas) > 0) {
    while ($fila = mysqli_fetch_assoc($resultadoTareasCompletadas)) {
        $tareasCompletadas[] = $fila;
    }
}

// Obtener los eventos completados del usuario
$sqlEventosCompletados = "SELECT e.id, e.nombre, eh.fecha_completado FROM eventos e 
                          JOIN eventos_hechos eh ON e.id = eh.evento_id 
                          WHERE eh.usuario='$usuario'";
$resultadoEventosCompletados = mysqli_query($conexion, $sqlEventosCompletados);
$eventosCompletados = array();

if (mysqli_num_rows($resultadoEventosCompletados) > 0) {
    while ($fila = mysqli_fetch_assoc($resultadoEventosCompletados)) {
        $eventosCompletados[] = $fila;
    }
}

// Lógica para cambiar la contraseña
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password_actual = $_POST['password_actual'];
    $nueva_contraseña = $_POST['nueva_contraseña'];

    // Verificar la contraseña actual
    if (password_verify($password_actual, $contraseña_actual_hash)) {
        // Crear el hash de la nueva contraseña
        $nueva_contraseña_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $sql = "UPDATE usuarios SET contraseña='$nueva_contraseña_hash' WHERE usuario='$usuario'";

        if (mysqli_query($conexion, $sql)) {
            $mensaje = "Contraseña actualizada correctamente.";
        } else {
            $mensaje = "Error al actualizar la contraseña.";
        }
    } else {
        $mensaje = "Error: La contraseña actual no es correcta.";
    }
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/editar_usuario.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="bienvenido.php">
                <img src="../css/fotos/Technology(1).png" alt="Logo" width="50" height="50" class="d-inline-block align-top" loading="lazy">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/bienvenido.php">
                            <i class="fas fa-tasks"></i> Mis Tareas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/crear_tareas.php">
                            <i class="fas fa-plus"></i> Crear 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/editar_usuario.php">
                            <i class="fas fa-user-edit"></i> Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../includes/cerrar_sesion.php">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <!-- Columna izquierda: Tareas y Eventos completados -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Tareas Completadas</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($tareasCompletadas)) : ?>
                            <ul class="list-group">
                                <?php foreach ($tareasCompletadas as $tarea) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><?php echo $tarea['titulo']; ?></span>
                                        <span class="badge badge-secondary"><?php echo $tarea['fecha_completado']; ?></span>
                                        <form action="../php/eliminar_completados.php" method="post" style="display: inline;">
                                            <input type="hidden" name="tarea_id" value="<?php echo $tarea['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-recycle"></i></i></button>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p>No hay tareas completadas.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h3>Eventos Completados</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($eventosCompletados)) : ?>
                            <ul class="list-group">
                                <?php foreach ($eventosCompletados as $evento) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><?php echo $evento['nombre']; ?></span>
                                        <span class="badge badge-secondary"><?php echo $evento['fecha_completado']; ?></span>
                                        <form action="../php/eliminar_completados.php" method="post" style="display: inline;">
                                            <input type="hidden" name="evento_id" value="<?php echo $evento['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-recycle"></i></button>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p>No hay eventos completados.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: Información del usuario y cambio de contraseña -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Editar Información de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Nombre de Usuario:</strong> <?php echo $_SESSION['usuario']; ?></p>
                        <p><strong>Correo Electrónico:</strong> <?php echo $email; ?></p>
                        <form action="../php/eliminar_cuenta.php" method="post" onsubmit="return confirm('¿Está seguro que desea eliminar su cuenta? Esta acción no se puede deshacer.');">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-exclamation-triangle"></i> Eliminar Cuenta</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h3>Cambiar Contraseña</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($mensaje)) : ?>
                            <div class="alert alert-info"><?php echo $mensaje; ?></div>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="password_actual">Contraseña Actual:</label>
                                <input type="password" id="password_actual" name="password_actual" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="nueva_contraseña">Nueva Contraseña:</label>
                                <input type="password" id="nueva_contraseña" name="nueva_contraseña" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
