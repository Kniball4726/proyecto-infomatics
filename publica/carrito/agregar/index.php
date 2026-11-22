<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/carrito.php';

requerirAuth();
requerirCliente();

$user = usuarioActual();
$idProducto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idProducto > 0 && $user) {
    agregarAlCarrito($user->id, $idProducto, 1);
}

header("Location: /carrito/todos");
exit();
