<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión o Registrarse</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container" id="login-container">
        <h2 style="color: white;">Iniciar Sesión</h2>
        <form action="login.php" method="post">
            <input type="text" placeholder="Usuario" name="usuario" required>
            <input type="password" placeholder="Contraseña" name="contraseña" required>
            <input type="submit" value="¡Entra ya!">
        </form>
        <p style="color: white;">¿No tienes una cuenta? <a href="#" id="registro-link" style="color: black;">Regístrate aquí</a>.</p>
    </div>

    <div class="container_registro" id="registro-container" style="display: none;">
        <h2 style="color: white;">Registrarse</h2>
        <form action="registro.php" method="post">
            <input type="text" placeholder="Usuario" name="usuario" id="usuario" required>
            <input type="email" placeholder="Correo Electrónico" name="email" id="email" required>
            <input type="password" placeholder="Contraseña" name="contraseña" id="contraseña" required>
            <input type="password" placeholder="Repetir Contraseña" name="contraseña_repetida" id="contraseña_repetida" required>
            <input type="submit" value="¡Bienvenido!">
        </form>
        <p style="color: white;">¿Ya tienes una cuenta? <a href="#" id="login-link" style="color: black;">Inicia sesión aquí</a>.</p>
    </div>
    <script src="../js/inicio_sesion.js"></script>
</body>
</html>

