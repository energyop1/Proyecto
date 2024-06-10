<?php
// Verificar si el formulario de registro fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once '../includes/conexion.php';
    
    // Obtener los datos del formulario de registro
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $contraseña_repetida = $_POST['contraseña_repetida'];

    // Inicializar variable de error
    $error = "";

    // Validar longitud del nombre de usuario
    if (strlen($usuario) < 5) {
        $error = "El nombre de usuario debe tener al menos 5 caracteres.";
    }
    
    // Validar formato de correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no tiene un formato válido.";
    }

    if ($contraseña !== $contraseña_repetida) {
        $error = "Las contraseñas no coinciden.";
    }

    // Comprobar si el usuario ya existe
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) > 0) {
        $error = "El nombre de usuario ya existe.";
    }

    // Comprobar si el correo ya existe
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) > 0) {
        $error = "El correo electrónico ya está registrado.";
    }

    // Si hay un error, mostrar una alerta en JavaScript y volver al formulario de registro
    if (!empty($error)) {
        echo "<script>alert('$error');</script>";
        echo "<script>window.location.href = '../pages/index.php';</script>";
    } else {
        // Crear el hash de la contraseña
        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

        // Consulta SQL para insertar un nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (usuario, email, contraseña) VALUES ('$usuario', '$email', '$contraseña_hash')";
        
        if (mysqli_query($conexion, $sql)) {
            // Registro exitoso, redirigir al usuario a la página de inicio de sesión
            header("Location: ../pages/index.php");
        } else {
            // Si hay un error en la inserción, mostrar mensaje de error
            echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
        }
    }
    
    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
}
?>
