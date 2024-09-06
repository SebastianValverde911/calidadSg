<?php
function getWeatherData($lat, $lon, $apiKey) {
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$apiKey";

    // Inicializar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error en la solicitud cURL: ' . curl_error($ch);
        curl_close($ch);
        return null; // Devuelve null si hay un error
    }

    curl_close($ch);

    // Decodificar la respuesta JSON de la API
    $data = json_decode($response, true);

    // Verificar si la respuesta es válida
    if (!$data) {
        echo "Error al decodificar los datos del clima.";
        return null;
    }

    return $data; // Devuelve los datos del clima
}
?>