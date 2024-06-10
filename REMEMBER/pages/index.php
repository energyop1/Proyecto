<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión o Registrarse</title>
    <link rel="stylesheet" href="../css/inicio.css">
</head>
<body>
    <!-- Contenedor del formulario de inicio de sesión -->
    <div class="container" id="login-container">
        <h2 style="color: white;">Iniciar Sesión</h2>
        <?php
        // Si hay un mensaje de error en la sesión, se muestra y luego se elimina
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <!-- Formulario de inicio de sesión -->
        <form action="../php/login.php" method="post">
            <input type="text" placeholder="Usuario" name="usuario" required>
            <input type="password" placeholder="Contraseña" name="contraseña" required>
            <input type="submit" value="¡Entra ya!">
        </form>
        <p style="color: white;">¿No tienes una cuenta? <a href="#" id="registro-link" style="color: black;">Regístrate aquí</a>.</p>
    </div>

    <!-- Contenedor del formulario de registro, oculto inicialmente -->
    <div class="container_registro" id="registro-container" style="display: none;">
        <h2 style="color: white;">Registrarse</h2>
        <?php
        // Si hay un mensaje de error de registro en la sesión, se muestra y luego se elimina
        if (isset($_SESSION['registro_error'])) {
            echo '<p class="error">' . $_SESSION['registro_error'] . '</p>';
            unset($_SESSION['registro_error']);
        }
        ?>
        <!-- Formulario de registro -->
        <form action="../php/registro.php" method="post">
            <input type="text" placeholder="Usuario" name="usuario" id="usuario" required>
            <input type="email" placeholder="Correo Electrónico" name="email" id="email" required>
            <input type="password" placeholder="Contraseña" name="contraseña" id="contraseña" required>
            <input type="password" placeholder="Repetir Contraseña" name="contraseña_repetida" id="contraseña_repetida" required>
            <input type="submit" value="¡Bienvenido!">
        </form>
        <p style="color: white;">¿Ya tienes una cuenta? <a href="#" id="login-link" style="color: black;">Inicia sesión aquí</a>.</p>
    </div>
    <!-- Inclusión del archivo JavaScript para manejar el cambio entre formularios -->
    <script src="../js/inicio_sesion.js"></script>
</body>
</html>
