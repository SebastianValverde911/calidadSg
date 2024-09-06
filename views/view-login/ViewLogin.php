<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/pruebatecnica/calidadSg/views/view-login/";
    ?>
    <link rel="stylesheet" href= "<?php echo $baseUrl; ?>ViewLogin.css">
    <title>Login</title>
</head>
<body>
    <div class="container-login">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="./index.php" method="post" class="form">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" required><br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Ingresar" class="btn-ingresar">
        </form>
        <p>¿No tienes una cuenta? <a href="./index.php?action=register">Regístrate aquí</a></p> <!-- Enlace al registro -->
    </div>
</body>
</body>
</html>