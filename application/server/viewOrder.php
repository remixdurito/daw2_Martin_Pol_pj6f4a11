<?php
// Muestra una página HTML con los datos de UNA comanda, buscada por su código.
require_once "functions.php";

// Recoge el código de la comanda enviado por GET (es una operación de lectura)
$id = $_GET["id"] ?? "";

// Lee todas las comandas del fichero orders.json
$orders = readJsonFile(__DIR__ . "/../../orders/orders.json");

if ($orders === null) {
    // El fichero no existe o no se puede abrir: error 404
    sendNotFound("The orders file was not found or could not be opened.");
    exit;
}

// Busca la comanda con el código recibido
$order = findOrderById($orders, $id);

if ($order === null) {
    // No existe ninguna comanda con ese código: error 404
    sendNotFound("Order not found: there is no order with code " . $id . ".");
    exit;
}

// Todo correcto: responde 200 OK + tabla con solo esa comanda
http_response_code(200);
renderOrdersPage([$order]);
