<?php
// Autenticación del usuario. Responde solo con un texto (OK o ERROR),
// sin HTML, tal como pide el enunciado.
require_once "functions.php";

// Recoge los datos enviados por POST desde el formulario de login
$user = $_POST["user"] ?? "";
$password = $_POST["password"] ?? "";

// Lee la lista de usuarios del fichero users.json (fichero predefinido)
$users = readJsonFile(__DIR__ . "/../../users/users.json");

// Si el usuario y la contraseña son correctos, responde 200 OK.
// Si no, responde 401 (no autorizado) para que el cliente muestre el error.
if ($users !== null && authenticateUser($users, $user, $password)) {
    http_response_code(200);
    echo "OK";
} else {
    http_response_code(401);
    echo "ERROR";
}
