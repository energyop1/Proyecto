<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Cambia localhost por la dirección del servidor si es necesario
$username = "paula"; // Nombre de usuario de la base de datos
$password = "alumno"; // Contraseña de la base de datos
$dbname = "remember"; // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Establecer el juego de caracteres de la conexión
$conexion->set_charset("utf8");

?>
