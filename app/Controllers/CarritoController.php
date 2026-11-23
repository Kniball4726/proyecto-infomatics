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
            $resultado = CarritoService::agregar($userId, $idProducto, $cantidad);
            if ($resultado['success']) {
                $nombre = htmlspecialchars($resultado['nombre'] ?? 'Producto');
                $restante = (int)($resultado['stockRestante'] ?? 0);
                $_SESSION['toast'] = [
                    'tipo' => 'success', 
                    'mensaje' => "🛒 '$nombre' agregado. Stock disponible restante: $restante."
                ];
            } else {
                $_SESSION['toast'] = [
                    'tipo' => 'error', 
                    'mensaje' => "⚠️ " . ($resultado['error'] ?? 'No hay stock disponible.')
                ];
            }
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
            $resultado = CarritoService::quitar($userId, $idProducto, $todo);
            if ($resultado['success']) {
                $restauradas = (int)($resultado['restauradas'] ?? 1);
                $_SESSION['toast'] = [
                    'tipo' => 'info', 
                    'mensaje' => $todo 
                        ? "🗑️ Producto eliminado del carrito (se restituyeron $restauradas u. al stock)." 
                        : "Se devolvió 1 unidad al stock disponible de la tienda."
                ];
            }
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/carrito/todos/';
        header("Location: $referer");
        exit();
    }
}
