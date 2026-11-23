<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Services\CarritoService;
use App\Views\View;

class CarritoController {
    public static function index(): void {
        AuthService::requerirAuth();
        AuthService::requerirCliente();

        $user = AuthService::usuarioActual();
        $userId = (int)($user->_id ?? $user->id ?? 0);

        $items = CarritoService::obtenerItems($userId);
        $resumen = CarritoService::obtenerResumen($userId);

        View::render('carrito.index', [
            'items' => $items,
            'resumen' => $resumen,
        ]);
    }

    public static function agregar(int $idProducto, int $cantidad = 1): void {
        AuthService::requerirAuth();
        AuthService::requerirCliente();

        $user = AuthService::usuarioActual();
        $userId = (int)($user->_id ?? $user->id ?? 0);

        if ($idProducto > 0) {
            CarritoService::agregar($userId, $idProducto, $cantidad);
            $_SESSION['toast'] = ['tipo' => 'success', 'mensaje' => '🛒 Producto agregado a tu carrito.'];
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $referer");
        exit();
    }

    public static function quitar(int $idProducto, bool $todo = false): void {
        AuthService::requerirAuth();
        AuthService::requerirCliente();

        $user = AuthService::usuarioActual();
        $userId = (int)($user->_id ?? $user->id ?? 0);

        if ($idProducto > 0) {
            CarritoService::quitar($userId, $idProducto, $todo);
            $_SESSION['toast'] = ['tipo' => 'info', 'mensaje' => $todo ? '🗑️ Producto quitado del carrito.' : 'Cantidad actualizada.'];
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/carrito/todos';
        header("Location: $referer");
        exit();
    }
}
