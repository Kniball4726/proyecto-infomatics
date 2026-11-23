<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Services\CsrfService;
use App\Services\PedidoService;
use App\Views\View;

class PedidoController {
    /**
     * Procesa la compra del carrito actual.
     */
    public static function finalizarCompra(): void {
        AuthService::requerirCliente();
        CsrfService::verificarOAbortar();

        $user = AuthService::usuarioActual();
        $userId = (int)($user->_id ?? $user->id ?? 0);

        $resultado = PedidoService::crearPedido($userId);

        if ($resultado['success']) {
            $_SESSION['toast'] = [
                'tipo' => 'success', 
                'mensaje' => "🎉 ¡Compra confirmada con éxito! Tu pedido #{$resultado['idPedido']} ha sido registrado y el stock actualizado."
            ];
            header("Location: /pedidos/ver/?id=" . $resultado['idPedido']);
            exit();
        } else {
            $_SESSION['toast'] = [
                'tipo' => 'error', 
                'mensaje' => $resultado['error'] ?? 'No se pudo completar la compra.'
            ];
            header("Location: /carrito/todos/");
            exit();
        }
    }

    /**
     * Muestra el listado de pedidos del usuario (o todos si es admin).
     */
    public static function listado(): void {
        AuthService::requerirAuth();
        $user = AuthService::usuarioActual();
        $esAdmin = AuthService::esAdmin();
        $userId = (int)($user->_id ?? $user->id ?? 0);

        $pedidos = $esAdmin 
            ? PedidoService::obtenerTodos() 
            : PedidoService::obtenerPorUsuario($userId);

        View::render('pedidos.listado', [
            'pedidos' => $pedidos,
            'esAdmin' => $esAdmin
        ]);
    }

    /**
     * Muestra el comprobante detallado de un pedido.
     */
    public static function ver(int $id): void {
        AuthService::requerirAuth();
        $user = AuthService::usuarioActual();
        $esAdmin = AuthService::esAdmin();
        $userId = $esAdmin ? null : (int)($user->_id ?? $user->id ?? 0);

        $pedido = PedidoService::obtenerPorId($id, $userId);

        if (!$pedido) {
            $_SESSION['toast'] = ['tipo' => 'error', 'mensaje' => 'El pedido solicitado no fue encontrado.'];
            header("Location: /pedidos/");
            exit();
        }

        View::render('pedidos.detalle', [
            'pedido' => $pedido,
            'esAdmin' => $esAdmin
        ]);
    }
}
