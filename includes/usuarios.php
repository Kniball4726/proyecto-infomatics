<?php
/**
 * Servicio de Gestión de Usuarios y Clientes (Delegado a App\Services\UsuarioService)
 */
require_once __DIR__ . '/../app/Services/UsuarioService.php';

use App\Services\UsuarioService;

function obtenerUsuarios(bool $soloClientes = false): array {
    return UsuarioService::obtenerTodos($soloClientes);
}

function obtenerUsuarioPorId(int $id): ?object {
    return UsuarioService::obtenerPorId($id);
}

function crearCliente(array $datos): bool {
    return UsuarioService::crear($datos);
}

function actualizarCliente(int $id, array $datos): bool {
    return UsuarioService::actualizar($id, $datos);
}

function eliminarCliente(int $id): bool {
    return UsuarioService::eliminar($id);
}
