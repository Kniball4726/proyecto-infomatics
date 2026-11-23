<?php
/**
 * Servicio de Autenticación y Control de Sesión (Delegado a App\Services\AuthService)
 */
require_once __DIR__ . '/../app/Services/AuthService.php';

use App\Services\AuthService;

AuthService::iniciarSesion();

function autenticarUsuario(string $usuarioOEmail, string $clave): bool {
    return AuthService::autenticar($usuarioOEmail, $clave);
}

function cerrarSesion(): void {
    AuthService::cerrarSesion();
}

function estaAutenticado(): bool {
    return AuthService::estaAutenticado();
}

function usuarioActual(): ?object {
    return AuthService::usuarioActual();
}

function esAdmin(): bool {
    return AuthService::esAdmin();
}

function esCliente(): bool {
    return AuthService::esCliente();
}

function requerirAuth(): void {
    AuthService::requerirAuth();
}

function requerirAdmin(): void {
    AuthService::requerirAdmin();
}

function requerirCliente(): void {
    AuthService::requerirCliente();
}
