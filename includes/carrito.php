<?php
/**
 * Servicio de Carrito (Delegado a App\Services\CarritoService)
 */
require_once __DIR__ . '/../app/Services/CarritoService.php';

use App\Services\CarritoService;

function obtenerResumenCarrito(int $idUsuario): object {
    return CarritoService::obtenerResumen($idUsuario);
}

function obtenerItemsCarrito(int $idUsuario): array {
    return CarritoService::obtenerItems($idUsuario);
}

function agregarAlCarrito(int $idUsuario, int $idProducto, int $cantidad = 1): bool {
    return CarritoService::agregar($idUsuario, $idProducto, $cantidad);
}

function quitarDelCarrito(int $idUsuario, int $idProducto, bool $todo = false): bool {
    return CarritoService::quitar($idUsuario, $idProducto, $todo);
}
