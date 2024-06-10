<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "paula"; 
$password = "alumno"; 
$dbname = "remember"; 

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

?>
