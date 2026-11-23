<?php
require_once __DIR__ . '/../../../../app/bootstrap.php';

use App\Services\CarritoService;

$idUsuario = (int)($_GET['nm_idUsuario'] ?? 0);
$idProducto = (int)($_GET['nm_idProducto'] ?? 0);
$cantidad = (int)($_GET['nm_cantidad'] ?? 1);

if ($idUsuario > 0 && $idProducto > 0) {
    CarritoService::agregar($idUsuario, $idProducto, $cantidad);
}

header("Location: /carrito/todos/");
exit();
