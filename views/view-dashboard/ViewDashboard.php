<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido</h2>
    <p>Has iniciado sesión con éxito.</p>
    <a href="../../index.php?logout=true">Cerrar sesión</a>
</body>
</html>