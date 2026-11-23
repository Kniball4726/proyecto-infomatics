<?php
namespace App\Services;

use App\Database\Connection;
use Exception;
use PDO;

class PedidoService {
    /**
     * Procesa la compra del carrito actual: valida stock, descuenta stock,
     * registra el pedido con sus líneas de detalle y vacía el carrito en una transacción atómica.
     */
    public static function crearPedido(int $idUsuario): array {
        if ($idUsuario <= 0) {
            return ['success' => false, 'error' => 'Usuario no válido.'];
        }

        $db = Connection::get();
        $db->beginTransaction();

        try {
            $items = CarritoService::obtenerItems($idUsuario);

            if (empty($items)) {
                $db->rollBack();
                return ['success' => false, 'error' => 'Tu carrito está vacío. Agrega productos antes de comprar.'];
            }

            $total = 0.0;
            // 1. Calcular importe total (el stock ya fue reservado/descontado en tiempo real al ingresar al carrito)
            foreach ($items as $item) {
                $total += ($item->_precio * $item->_cantidad);
            }

            // 2. Insertar encabezado de pedido
            $stmtPedido = $db->prepare("
                INSERT INTO TPedidos (_idUsuario, _total, _estado, _fecha)
                VALUES (?, ?, 'Completado', datetime('now', 'localtime'))
            ");
            $stmtPedido->execute([$idUsuario, $total]);
            $idPedido = (int)$db->lastInsertId();

            // 3. Insertar detalle de cada producto vendido
            $stmtDetalle = $db->prepare("
                INSERT INTO TDetallePedido (_idPedido, _idProducto, _cantidad, _precioUnitario, _subtotal)
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($items as $item) {
                $subtotal = $item->_precio * $item->_cantidad;
                $stmtDetalle->execute([
                    $idPedido,
                    $item->producto_id,
                    $item->_cantidad,
                    $item->_precio,
                    $subtotal
                ]);
            }

            // 4. Vaciar carrito del usuario (la compra se confirma y los productos quedan asignados al pedido)
            $stmtVaciar = $db->prepare("DELETE FROM TCarrito WHERE _idUsuario = ?");
            $stmtVaciar->execute([$idUsuario]);

            $db->commit();

            return [
                'success' => true,
                'idPedido' => $idPedido,
                'total' => $total,
                'itemsCount' => count($items)
            ];
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            return ['success' => false, 'error' => 'Error al procesar la compra: ' . $e->getMessage()];
        }
    }

    /**
     * Obtiene el listado de pedidos de un cliente.
     */
    public static function obtenerPorUsuario(int $idUsuario): array {
        $db = Connection::get();
        $stmt = $db->prepare("
            SELECT * FROM TPedidos 
            WHERE _idUsuario = ? 
            ORDER BY _id DESC
        ");
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene el detalle completo de un pedido con sus líneas de productos.
     */
    public static function obtenerPorId(int $idPedido, ?int $idUsuario = null): ?object {
        $db = Connection::get();
        if ($idUsuario !== null) {
            $stmt = $db->prepare("
                SELECT p.*, u._nombre as cliente_nombre, u._apellido as cliente_apellido, u._email as cliente_email 
                FROM TPedidos p
                JOIN TUsuarios u ON p._idUsuario = u._id
                WHERE p._id = ? AND p._idUsuario = ?
                LIMIT 1
            ");
            $stmt->execute([$idPedido, $idUsuario]);
        } else {
            $stmt = $db->prepare("
                SELECT p.*, u._nombre as cliente_nombre, u._apellido as cliente_apellido, u._email as cliente_email 
                FROM TPedidos p
                JOIN TUsuarios u ON p._idUsuario = u._id
                WHERE p._id = ?
                LIMIT 1
            ");
            $stmt->execute([$idPedido]);
        }

        $pedido = $stmt->fetch();
        if (!$pedido) {
            return null;
        }

        $stmtItems = $db->prepare("
            SELECT d.*, pr._nombre, pr._imagen, pr._categoria 
            FROM TDetallePedido d
            JOIN TProductos pr ON d._idProducto = pr._id
            WHERE d._idPedido = ?
            ORDER BY d._id ASC
        ");
        $stmtItems->execute([$idPedido]);
        $pedido->items = $stmtItems->fetchAll();

        return $pedido;
    }

    /**
     * Obtiene todos los pedidos registrados (para administradores).
     */
    public static function obtenerTodos(): array {
        $db = Connection::get();
        $stmt = $db->query("
            SELECT p.*, u._nombre as cliente_nombre, u._apellido as cliente_apellido, u._email as cliente_email
            FROM TPedidos p
            JOIN TUsuarios u ON p._idUsuario = u._id
            ORDER BY p._id DESC
        ");
        return $stmt->fetchAll();
    }
}
