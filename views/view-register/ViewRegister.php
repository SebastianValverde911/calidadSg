<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/pruebatecnica/calidadSg/views/view-register/";
    ?>
    <link rel="stylesheet" href= "<?php echo $baseUrl; ?>ViewRegister.css">
    <title>Registro</title>
</head>
<body>
    <div class="container-register">
        <h2>Registro de Usuario</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="./index.php?action=register" method="post">
            <label for="name">Nombre:</label>
            <input type="name" name="name" required><br>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" required><br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br>
            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" name="confirm_password" required><br>
            <input type="submit" value="Registrarse" class="btn-register">
        </form>
        <p>¿Ya tienes una cuenta? <a href="./index.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>