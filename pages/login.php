<?php
session_start();

// Verificar si el formulario de inicio de sesión fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once '../includes/conexion.php';
    
    // Obtener los datos del formulario de inicio de sesión
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    
    // Consulta SQL para obtener el hash de la contraseña del usuario
    $sql = "SELECT contraseña FROM usuarios WHERE usuario='$usuario'";
    $resultado = mysqli_query($conexion, $sql);
    
    // Verificar si se encontró el usuario
    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);
        $contraseña_hash = $fila['contraseña'];
        
        // Verificar si la contraseña ingresada coincide con el hash almacenado
        if (password_verify($contraseña, $contraseña_hash)) {
            // Inicio de sesión exitoso, redirigir al usuario a la página de bienvenida
            $_SESSION['usuario'] = $usuario;
            header("Location: bienvenido.php");
        } else {
            // Si la contraseña no coincide, mostrar mensaje de error
            echo "Usuario o contraseña incorrectos";
        }
    } else {
        // Si no se encontró el usuario, mostrar mensaje de error
        echo "Usuario o contraseña incorrectos";
    }
}
?>
