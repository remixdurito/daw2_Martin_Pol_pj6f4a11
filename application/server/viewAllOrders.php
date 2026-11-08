<?php
// Muestra una página HTML con la tabla de TODAS las comandas guardadas.
require_once "functions.php";

// Lee todas las comandas del fichero orders.json
$orders = readJsonFile(__DIR__ . "/../../orders/orders.json");

if ($orders === null) {
    // El fichero no existe o no se puede abrir: error 404 + página de error
    sendNotFound("The orders file was not found or could not be opened.");
    exit;
}

// Todo correcto: responde 200 OK + página con la tabla de comandas
http_response_code(200);
renderOrdersPage($orders);
