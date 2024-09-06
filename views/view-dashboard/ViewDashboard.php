<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../../services/apiWeather.php';
require_once '../../config/database.php'; // Archivo de configuración para la conexión a la base de datos

$data = "";
$apiKey = "7035b51bc232252d6c381e50e7027131"; // Tu clave API de OpenWeatherMap

if (isset($_POST['city'])) {
    $city = $_POST['city']; // Capturamos la ciudad ingresada por el usuario
    $userId = $_SESSION['user_id']; // ID del usuario autenticado

    // Obtener los datos del clima de la API
    $data = getWeatherData($city, $apiKey);

    if ($data) {
        // Conectar a la base de datos usando PDO
        $database = new Database();
        $db = $database->getConnection();

        // Preparar los datos para insertar en la base de datos
        $temperature = $data['main']['temp'] - 273.15; // Convertir de Kelvin a Celsius
        $description = ucfirst($data['weather'][0]['description']);
        $queryTime = date('Y-m-d H:i:s');

        // Insertar en la base de datos
        $query = "INSERT INTO weatherusers (user_id, city, temperature, description, query_time) VALUES (:user_id, :city, :temperature, :description, :query_time)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':temperature', $temperature);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':query_time', $queryTime);

        if ($stmt->execute()) {
            echo "Consulta guardada exitosamente.";
        } else {
            echo "Error al guardar la consulta.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/pruebatecnica/calidadSg/views/view-dashboard/";
    ?>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>ViewDashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido al Dashboard</h1>
    <h2>Consulta el Clima:</h2>

    <!-- Formulario para pedir la ciudad -->
    <form method="post" action="">
        <label for="city">Ingresa tu ciudad:</label>
        <input type="text" id="city" name="city" required>
        <button type="submit">Consultar</button>
    </form>

    <?php if ($data): ?>
        <h2>Datos del Clima en <?php echo htmlspecialchars($city); ?>:</h2>
        <p>Ubicación: <?php echo $data['name']; ?>, <?php echo $data['sys']['country']; ?></p>
        <p>Temperatura actual: <?php echo $data['main']['temp'] - 273.15; ?>°C</p>
        <p>Sensación térmica: <?php echo $data['main']['feels_like'] - 273.15; ?>°C</p>
        <p>Temperatura mínima: <?php echo $data['main']['temp_min'] - 273.15; ?>°C</p>
        <p>Temperatura máxima: <?php echo $data['main']['temp_max'] - 273.15; ?>°C</p>
        <p>Humedad: <?php echo $data['main']['humidity']; ?>%</p>
        <p>Descripción: <?php echo ucfirst($data['weather'][0]['description']); ?></p>
        <p>Velocidad del viento: <?php echo $data['wind']['speed']; ?> m/s</p>
        <img src="https://openweathermap.org/img/wn/<?php echo $data['weather'][0]['icon']; ?>@2x.png" alt="Icono del clima">
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No se pudieron obtener los datos del clima para la ciudad ingresada.</p>
    <?php endif; ?>

    <!-- Mostrar el historial de consultas del usuario -->
    <h2>Historial de Consultas:</h2>
    <?php
    // Conectar a la base de datos para obtener el historial
    $database = new Database();
    $db = $database->getConnection();

    $userId = $_SESSION['user_id'];
    $query = "SELECT city, temperature, description, query_time FROM weatherusers WHERE user_id = :user_id ORDER BY query_time DESC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li><strong>Ciudad:</strong> {$row['city']} - <strong>Temperatura:</strong> {$row['temperature']}°C - <strong>Descripción:</strong> {$row['description']} - <strong>Fecha:</strong> {$row['query_time']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay consultas previas.</p>";
    }
    ?>

    <a href="../../index.php?logout=true">Cerrar sesión</a>
</body>
</html>