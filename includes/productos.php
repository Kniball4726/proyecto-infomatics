<?php
/**
 * Servicio de Productos (Delegado a App\Services\ProductoService)
 */
require_once __DIR__ . '/../app/Services/ProductoService.php';

use App\Services\ProductoService;

function obtenerProductos(string $orden = 'DESC'): array {
    return ProductoService::obtenerTodos($orden);
}

function obtenerProductoPorId(int $id): ?object {
    return ProductoService::obtenerPorId($id);
}

function crearProducto(array $datos): int {
    return ProductoService::crear($datos);
}

function actualizarProducto(int $id, array $datos): bool {
    return ProductoService::actualizar($id, $datos);
}

function eliminarProducto(int $id): bool {
    return ProductoService::eliminar($id);
}
