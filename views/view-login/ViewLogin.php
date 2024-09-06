<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form action="./index.php" method="post">
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required><br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Ingresar">
    </form>
    <p>¿No tienes una cuenta? <a href="./index.php?action=register">Regístrate aquí</a></p> <!-- Enlace al registro -->
</body>
</body>
</html>