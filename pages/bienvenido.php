<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

include_once '../includes/conexion.php';

// Verificar si se recibió una solicitud para cambiar el color
if (isset($_POST['cambiarColor'])) {
    // Obtener los datos de la solicitud
    $tipo = $_POST['tipo'];
    $id = $_POST['id'];
    $color = $_POST['color'];

    // Actualizar el color en la base de datos
    $sql = "";
    if ($tipo === 'tarea') {
        $sql = "UPDATE tareas SET color='$color' WHERE id=$id";
    } else if ($tipo === 'evento') {
        $sql = "UPDATE eventos SET color='$color' WHERE id=$id";
    }

    if (mysqli_query($conexion, $sql)) {
        // Devolver una respuesta JSON indicando éxito
        echo json_encode(array('success' => true));
    } else {
        // Devolver una respuesta JSON indicando error
        echo json_encode(array('success' => false, 'message' => 'Error al actualizar el color en la base de datos'));
    }
    exit; // Salir del script después de manejar la solicitud
}

// Obtener el criterio de ordenación para tareas
$ordenarTareasPor = isset($_GET['ordenarTareasPor']) ? $_GET['ordenarTareasPor'] : 'fecha';
$ordenTareasSQL = $ordenarTareasPor === 'urgencia' ? 'nivel_urgencia DESC, dia_limite ASC' : 'dia_limite DESC';

// Obtener las tareas del usuario que no han sido completadas
$usuario = $_SESSION['usuario'];
$sqlTareas = "SELECT * FROM tareas WHERE usuario='$usuario' AND id NOT IN (SELECT tarea_id FROM tareas_hechas WHERE usuario='$usuario') ORDER BY $ordenTareasSQL";
$resultadoTareas = mysqli_query($conexion, $sqlTareas);

// Array para almacenar las tareas
$tareas = array();

if (mysqli_num_rows($resultadoTareas) > 0) {
    while ($fila = mysqli_fetch_assoc($resultadoTareas)) {
        $tareas[] = $fila;
    }
}

// Obtener el criterio de ordenación para eventos
$ordenarEventosPor = isset($_GET['ordenarEventosPor']) ? $_GET['ordenarEventosPor'] : 'fecha';
$ordenEventosSQL = 'dia_inicio DESC'; // Por defecto ordenamos eventos por fecha

// Obtener los eventos del usuario que no han sido completados
$sqlEventos = "SELECT * FROM eventos WHERE usuario='$usuario' AND id NOT IN (SELECT evento_id FROM eventos_hechos WHERE usuario='$usuario') ORDER BY $ordenEventosSQL";
$resultadoEventos = mysqli_query($conexion, $sqlEventos);

// Array para almacenar los eventos
$eventos = array();

if (mysqli_num_rows($resultadoEventos) > 0) {
    while ($fila = mysqli_fetch_assoc($resultadoEventos)) {
        $eventos[] = $fila;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <script src="../js/index.global.js"></script>
    <script src="../js/index.global.min.js"></script>
    
    <link rel="stylesheet" href="../css/bienvenido.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
<div class="container-fluid">
    <a class="navbar-brand" href="#"><h3>Hola de nuevo, <?php echo $_SESSION['usuario']; ?>!</h3></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="bienvenido.php">
                    <i class="fas fa-tasks"></i>
                    Mis Tareas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="crear_tareas.php">
                    <i class="fas fa-plus"></i>
                    Crear Tareas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="editar_usuario.php">
                    <i class="fas fa-user-edit"></i>
                    Perfil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../includes/cerrar_sesion.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
                </a>
            </li>
        </ul>
    </div>
</div>
</nav>

<div class="container-fluid mt-5">
<div class="row">
    <div class="col-md-3">
        <h2>Tus Tareas:</h2>
        <form id="ordenarTareasForm" method="GET" action="bienvenido.php">
            <select name="ordenarTareasPor" id="ordenarTareasPor" class="form-control mb-3" onchange="this.form.submit()">
                <option value="fecha" <?php echo (isset($_GET['ordenarTareasPor']) && $_GET['ordenarTareasPor'] == 'fecha') ? 'selected' : ''; ?>>Fecha más reciente</option>
                <option value="urgencia" <?php echo (isset($_GET['ordenarTareasPor']) && $_GET['ordenarTareasPor'] == 'urgencia') ? 'selected' : ''; ?>>Más urgente</option>
            </select>
        </form>
        <?php if (!empty($tareas)) : ?>
            <div class="list-group">
            <?php foreach ($tareas as $tarea) : ?>
                <div id="tarea-<?php echo $tarea['id']; ?>" class="list-group-item list-group-item-action"                 style="border-left: 5px solid <?php echo $tarea['color']; ?>">
                    <span><?php echo $tarea['titulo']; ?></span>
                    <span class="badge badge-secondary"><?php echo $tarea['dia_limite']; ?></span>
                    <button type="button" class="btn btn-info btn-sm float-right" onclick="toggleDetallesTarea(<?php echo $tarea['id']; ?>)">
                        <i class="fas fa-search"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm delete-task" data-id="<?php echo $tarea['id']; ?>">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="collapse" id="detalle-tarea-<?php echo $tarea['id']; ?>">
                        <div class="card card-body">
                            <h5>Detalles de la Tarea</h5>
                            <p><strong>Título:</strong> <?php echo $tarea['titulo']; ?></p>
                            <p><strong>Descripción:</strong> <?php echo $tarea['descripcion']; ?></p>
                            <p><strong>Nivel de Urgencia:</strong> <?php echo $tarea['nivel_urgencia']; ?></p>
                            <button type="button" class="btn btn-warning" onclick="marcarCompleto('tarea', <?php echo $tarea['id']; ?>)">
                                <i class="fas fa-star"></i> Marcar como completado
                            </button>
                            <form method="POST" class="mt-2 cambiar-color-form">
                                <input type="hidden" name="tipo" value="tarea">
                                <input type="hidden" name="id" value="<?php echo $tarea['id']; ?>">
                                <input type="color" name="color" value="<?php echo $tarea['color']; ?>" onchange="cambiarColorTarea(this)">
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay tareas por el momento.</p>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <div id="calendar"></div>
    </div>
    <div class="col-md-3">
        <h2>Tus Eventos:</h2>
        <form id="ordenarEventosForm" method="GET" action="bienvenido.php">
            <select name="ordenarEventosPor" id="ordenarEventosPor" class="form-control mb-3" onchange="this.form.submit()">
                <option value="fecha" <?php echo (isset($_GET['ordenarEventosPor']) && $_GET['ordenarEventosPor'] == 'fecha') ? 'selected' : ''; ?>>Fecha más reciente</option>
            </select>
        </form>
        <?php if (!empty($eventos)) : ?>
            <div class="list-group">
            <?php foreach ($eventos as $evento) : ?>
                <div id="evento-<?php echo $evento['id']; ?>" class="list-group-item list-group-item-action" style="border-left: 5px solid <?php echo $evento['color']; ?>">
                    <span><?php echo $evento['nombre']; ?></span>
                    <span class="badge badge-secondary"><?php echo $evento['dia_inicio']; ?></span>
                    <button type="button" class="btn btn-info btn-sm float-right" onclick="toggleDetallesEvento(<?php echo $evento['id']; ?>)">
                        <i class="fas fa-search"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm delete-event" data-id="<?php echo $evento['id']; ?>">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="collapse" id="detalle-evento-<?php echo $evento['id']; ?>">
                        <div class="card card-body">
                            <h5>Detalles del Evento</h5>
                            <p><strong>Nombre:</strong> <?php echo $evento['nombre']; ?></p>
                            <p><strong>Descripción:</strong> <?php echo $evento['descripcion']; ?></p>
                            <p><strong>Fecha de Inicio:</strong> <?php echo $evento['dia_inicio']; ?></p>
                            <p><strong>Fecha de Finalización:</strong> <?php echo $evento['dia_final']; ?></p>
                            <button type="button" class="btn btn-warning" onclick="marcarCompleto('evento', <?php echo $evento['id']; ?>)">
                                <i class="fas fa-star"></i> Marcar como completado
                            </button>
                            <form method="POST" class="mt-2 cambiar-color-form">
                                <input type="hidden" name="tipo" value="evento">
                                <input type="hidden" name="id" value="<?php echo $evento['id']; ?>">
                                <input type="color" name="color" value="<?php echo $evento['color']; ?>" onchange="cambiarColorEvento(this)">
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay eventos por el momento.</p>
        <?php endif; ?>
    </div>
</div>
</div>

<script>
function toggleDetallesTarea(id) {
    $('#detalle-tarea-' + id).collapse('toggle');
}

function toggleDetallesEvento(id) {
    $('#detalle-evento-' + id).collapse('toggle');
}

function cambiarColorTarea(input) {
    var form = $(input).closest('form');
    var tipo = form.find('input[name="tipo"]').val();
    var id = form.find('input[name="id"]').val();
    var color = input.value;

    $.ajax({
        url: 'bienvenido.php',
        method: 'POST',
        data: {
            cambiarColor: 1,
            tipo: tipo,
            id: id,
            color: color
        },
        success: function(response) {
            // Actualizar el borde del elemento
            $('#tarea-' + id).css('border-left', '5px solid ' + color);
            // Actualizar el evento en el calendario
            var event = calendar.getEventById(id);
            if (event) {
                event.setProp('color', color);
            }
        },
        error: function(xhr, status, error) {
            alert('Error al cambiar el color: ' + error);
        }
    });
}

function cambiarColorEvento(input) {
    var form = $(input).closest('form');
    var tipo = form.find('input[name="tipo"]').val();
    var id = form.find('input[name="id"]').val();
    var color = input.value;

    $.ajax({
        url: 'bienvenido.php',
        method: 'POST',
        data: {
            cambiarColor: 1,
            tipo: tipo,
            id: id,
            color: color
        },
        success: function(response) {
            // Actualizar el borde del elemento
            $('#evento-' + id).css('border-left', '5px solid ' + color);
            // Actualizar el evento en el calendario
            var event = calendar.getEventById(id);
            if (event) {
                event.setProp('color', color);
            }
        },
        error: function(xhr, status, error) {
            alert('Error al cambiar el color: ' + error);
        }
    });
}

function marcarCompleto(tipo, id) {
    $.post('completo.php', { tipo: tipo, id: id }, function(response) {
        if (response.success) {
            alert('Marcado como completado correctamente.');
            // Ocultar la tarjeta correspondiente
            if (tipo === 'tarea') {
                $('#tarea-' + id).fadeOut();
            } else if (tipo === 'evento') {
                $('#evento-' + id).fadeOut();
            }
        } else {
            alert('Error al marcar como completado: ' + response.message);
        }
    }, 'json');
}
$(document).ready(function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            <?php foreach ($tareas as $tarea) : ?>
                {
                    id: '<?php echo $tarea['id']; ?>',
                    title: '<?php echo addslashes($tarea['titulo']); ?>',
                    start: '<?php echo $tarea['dia_limite']; ?>',
                    color: '<?php echo $tarea['color']; ?>'
                },
            <?php endforeach; ?>
            <?php foreach ($eventos as $evento) : ?>
                {
                    id: '<?php echo $evento['id']; ?>',
                    title: '<?php echo addslashes($evento['nombre']); ?>',
                    start: '<?php echo $evento['dia_inicio']; ?>',
                    end: '<?php echo $evento['dia_final']; ?>',
                    color: '<?php echo $evento['color']; ?>'
                },
            <?php endforeach; ?>
        ]
    });
    calendar.render();

    $('.delete-task').click(function() {
        var id = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas borrar esta tarea?')) {
            $.post('borrar_tarea.php', { id: id }, function(response) {
                location.reload();
            });
        }
    });

    $('.delete-event').click(function() {
        var id = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas borrar este evento?')) {
            $.post('borrar_evento.php', { id: id }, function(response) {
                location.reload();
            });
        }
    });
});
</script>

</body>
</html>
