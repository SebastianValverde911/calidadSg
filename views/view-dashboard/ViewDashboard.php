<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../../services/apiWeather.php';

// Configurar los parámetros necesarios
$lat = "33.44"; // Latitud del lugar
$lon = "-94.04"; // Longitud del lugar
$apiKey = "7035b51bc232252d6c381e50e7027131"; // Tu clave API de OpenWeatherMap

// Obtener los datos del clima llamando a la función
$data = getWeatherData($lat, $lon, $apiKey);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido al Dashboard</h1>
    <h2>Datos del Clima:</h2>
    <?php if ($data): ?>
        <p>Ubicación: <?php echo $data['name']; ?>, <?php echo $data['sys']['country']; ?></p>
        <p>Temperatura actual: <?php echo $data['main']['temp'] - 273.15; ?>°C</p> <!-- Convertimos de Kelvin a Celsius -->
        <p>Sensación térmica: <?php echo $data['main']['feels_like'] - 273.15; ?>°C</p>
        <p>Temperatura mínima: <?php echo $data['main']['temp_min'] - 273.15; ?>°C</p>
        <p>Temperatura máxima: <?php echo $data['main']['temp_max'] - 273.15; ?>°C</p>
        <p>Humedad: <?php echo $data['main']['humidity']; ?>%</p>
        <p>Descripción: <?php echo ucfirst($data['weather'][0]['description']); ?></p>
        <p>Velocidad del viento: <?php echo $data['wind']['speed']; ?> m/s</p>
        <!-- Muestra el ícono del clima proporcionado por OpenWeatherMap -->
        <img src="https://openweathermap.org/img/wn/<?php echo $data['weather'][0]['icon']; ?>@2x.png" alt="Icono del clima">
    <?php else: ?>
        <p>No se pudieron obtener los datos del clima.</p>
    <?php endif; ?>
    <a href="../../index.php?logout=true">Cerrar sesión</a>
</body>
</html>