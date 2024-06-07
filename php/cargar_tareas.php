<?php
// Incluir archivo de conexión a la base de datos
include_once '../includes/conexion.php';

// Verificar si se ha recibido el filtro
if(isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];

    // Dependiendo del filtro recibido, realizar la consulta correspondiente
    if($filtro === 'fecha') {
        $sql = "SELECT * FROM tareas ORDER BY dia_limite ASC";
    } elseif($filtro === 'urgencia') {
        $sql = "SELECT * FROM tareas ORDER BY nivel_urgencia DESC";
    } else {
        // Si se recibe un filtro desconocido, devolver un error
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Filtro no válido'));
        exit();
    }

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);

    // Verificar si se obtuvieron resultados
    if(mysqli_num_rows($resultado) > 0) {
        // Convertir los resultados en un array asociativo
        $tareas = array();
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $tareas[] = $fila;
        }
        
        // Devolver los resultados en formato JSON
        header('Content-Type: application/json');
        echo json_encode($tareas);
    } else {
        // Si no se encontraron tareas, devolver un mensaje indicando eso
        header('Content-Type: application/json');
        echo json_encode(array('mensaje' => 'No hay tareas disponibles'));
    }
} else {
    // Si no se proporciona un filtro, devolver un mensaje de error
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Filtro no proporcionado'));
}
?>
