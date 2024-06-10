<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tareas y Eventos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/crear_tarea.css">
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
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
                        <i class="fas fa-tasks"></i>
                        Mis Tareas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/crear_tareas.php">
                        <i class="fas fa-plus"></i>
                        Crear
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/editar_usuario.php">
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

<div class="content-container container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-3 mb-5 pt-5 bg-white rounded">
                <h2 class="mb-4">Crea una nueva tarea:</h2>
                <form action="../php/proceso_tarea.php" method="post" onsubmit="return validateDate()">
                    <div class="form-group">
                        <input type="text" name="titulo" class="form-control" placeholder="Título de la tarea" required>
                    </div>
                    <div class="form-group">
                        <textarea name="descripcion" class="form-control" placeholder="Descripción de la tarea" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="dia_limite">Día Límite:</label>
                        <input type="date" name="dia_limite" class="form-control" min="2024-01-01" required>
                    </div>
                    <div class="form-group">
                        <label for="nivel_urgencia">Nivel de Urgencia:</label>
                        <div class="d-flex">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <button type="button" class="btn btn-outline-secondary mr-2 btn-pencil" data-urgencia="<?php echo $i; ?>" onclick="toggleColor(this)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                            <?php endfor; ?>
                            <input type="hidden" name="nivel_urgencia" id="nivel_urgencia" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="color" name="color" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Crear Tarea</button>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow p-3 mb-5 pt-5 bg-white rounded">
                <h2 class="mb-4">Crea un nuevo evento:</h2>
                <form action="../php/proceso_evento.php" method="post" onsubmit="return validateEventDates()">
                    <div class="form-group">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del evento" required>
                    </div>
                    <div class="form-group">
                        <textarea name="descripcion" class="form-control" placeholder="Descripción del evento" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="dia_inicio">Día de Inicio:</label>
                        <input type="date" name="dia_inicio" class="form-control" min="2024-01-01" required>
                    </div>
                    <div class="form-group">
                        <label for="dia_final">Día Final:</label>
                        <input type="date" name="dia_final" class="form-control" min="2024-01-01" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="color" name="color" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Crear Evento</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../js/crear_tareas.js"></script>
</body>
</html>

