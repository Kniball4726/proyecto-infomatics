<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/carrito.php';

requerirAuth();
requerirCliente();

$user = usuarioActual();
$idProducto = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$eliminarTodo = isset($_GET['todo']) && $_GET['todo'] == 1;

if ($idProducto > 0 && $user) {
    quitarDelCarrito($user->id, $idProducto, $eliminarTodo);
}

header("Location: /carrito/todos");
exit();
