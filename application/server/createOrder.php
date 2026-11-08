<?php
// Crea una comanda nueva: calcula el IVA y la guarda en orders.json.
// Responde solo con el precio final, sin HTML/JS/CSS.
require_once "functions.php";

$ordersPath = __DIR__ . "/../../orders/orders.json";

// Construye el array asociativo multidimensional con los productos
// marcados en el formulario, y calcula el total con el 21% de IVA
$products = buildProductList($_POST["products"] ?? []);
$total = calculateTotalWithVat($products);

// Construye la comanda completa, con los datos del cliente anidados
// dentro de un array asociativo ("customer") y la lista de productos
$order = [
    "orderId" => $_POST["orderId"] ?? "",
    "customer" => [
        "fullName" => $_POST["fullName"] ?? "",
        "address" => $_POST["address"] ?? "",
        "email" => $_POST["email"] ?? "",
        "phone" => $_POST["phone"] ?? ""
    ],
    "products" => $products,
    "totalWithVat" => $total
];

// Si orders.json no existe todavía, se crea con esta primera comanda.
// Si existe pero no se puede abrir, se responde con un error 404.
if (file_exists($ordersPath)) {
    $orders = readJsonFile($ordersPath);
    if ($orders === null) {
        sendNotFound("The orders file could not be opened.");
        exit;
    }
} else {
    $orders = [];
}

// Añade la nueva comanda a la lista y la guarda en el fichero
$orders[] = $order;

if (!writeJsonFile($ordersPath, $orders)) {
    sendNotFound("The orders file could not be saved.");
    exit;
}

// Todo correcto: responde 200 OK solo con el precio final
http_response_code(200);
echo number_format($total, 2, ".", "");
