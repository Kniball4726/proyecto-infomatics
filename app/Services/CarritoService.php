<?php
namespace App\Services;

use App\Database\Connection;
use Exception;
use PDO;

class CarritoService {
    public static function obtenerResumen(int $idUsuario): object {
        $db = Connection::get();
        $stmt = $db->prepare("
            SELECT 
                COALESCE(SUM(c._cantidad), 0) AS total_items,
                COALESCE(SUM(c._cantidad * p._precio), 0) AS total_precio
            FROM TCarrito c
            JOIN TProductos p ON c._idProducto = p._id
            WHERE c._idUsuario = ?
        ");
        $stmt->execute([$idUsuario]);
        return $stmt->fetch() ?: (object)['total_items' => 0, 'total_precio' => 0];
    }

    public static function obtenerItems(int $idUsuario): array {
        $db = Connection::get();
        $stmt = $db->prepare("
            SELECT 
                c._id AS carrito_id,
                c._cantidad,
                p._id AS producto_id,
                p._nombre,
                p._precio,
                p._imagen,
                p._stock,
                p._categoria,
                (c._cantidad * p._precio) AS subtotal
            FROM TCarrito c
            JOIN TProductos p ON c._idProducto = p._id
            WHERE c._idUsuario = ?
            ORDER BY c._id DESC
        ");
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll();
    }

    /**
     * Agrega un producto al carrito y descuenta el stock en tiempo real.
     * Retorna array con ['success' => bool, 'stockRestante' => int, 'nombre' => string, 'error' => string]
     */
    public static function agregar(int $idUsuario, int $idProducto, int $cantidad = 1): array {
        if ($idUsuario <= 0 || $idProducto <= 0 || $cantidad <= 0) {
            return ['success' => false, 'error' => 'Parámetros no válidos.'];
        }

        $db = Connection::get();
        $db->beginTransaction();

        try {
            // 1. Consultar el producto y su stock disponible actual
            $stmt = $db->prepare("SELECT _id, _nombre, _stock FROM TProductos WHERE _id = ? AND _activo = 1");
            $stmt->execute([$idProducto]);
            $producto = $stmt->fetch();

            if (!$producto) {
                $db->rollBack();
                return ['success' => false, 'error' => 'El producto solicitado no existe o no se encuentra activo.'];
            }

            if ($producto->_stock <= 0) {
                $db->rollBack();
                return [
                    'success' => false, 
                    'error' => "El producto '{$producto->_nombre}' ya no tiene unidades disponibles (Agotado)."
                ];
            }

            if ($producto->_stock < $cantidad) {
                $db->rollBack();
                return [
                    'success' => false, 
                    'error' => "Solo quedan {$producto->_stock} unidades disponibles de '{$producto->_nombre}'."
                ];
            }

            // 2. Descontar stock inmediatamente en tiempo real en TProductos
            $stmtStock = $db->prepare("UPDATE TProductos SET _stock = _stock - ? WHERE _id = ?");
            $stmtStock->execute([$cantidad, $idProducto]);

            // 3. Insertar o actualizar la cantidad en el carrito del usuario
            $stmtCart = $db->prepare("
                INSERT INTO TCarrito (_idUsuario, _idProducto, _cantidad)
                VALUES (?, ?, ?)
                ON CONFLICT(_idUsuario, _idProducto) 
                DO UPDATE SET _cantidad = _cantidad + excluded._cantidad
            ");
            $stmtCart->execute([$idUsuario, $idProducto, $cantidad]);

            $nuevoStock = $producto->_stock - $cantidad;

            $db->commit();

            return [
                'success' => true,
                'nombre' => $producto->_nombre,
                'stockRestante' => $nuevoStock
            ];
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            return ['success' => false, 'error' => 'Error al agregar al carrito: ' . $e->getMessage()];
        }
    }

    /**
     * Quita unidades del carrito y restituye el stock a TProductos en tiempo real.
     */
    public static function quitar(int $idUsuario, int $idProducto, bool $todo = false): array {
        if ($idUsuario <= 0 || $idProducto <= 0) {
            return ['success' => false, 'error' => 'Parámetros no válidos.'];
        }

        $db = Connection::get();
        $db->beginTransaction();

        try {
            // Consultar cantidad actual en carrito
            $stmt = $db->prepare("SELECT _cantidad FROM TCarrito WHERE _idUsuario = ? AND _idProducto = ?");
            $stmt->execute([$idUsuario, $idProducto]);
            $row = $stmt->fetch();

            if (!$row) {
                $db->rollBack();
                return ['success' => false, 'error' => 'El producto no está en tu carrito.'];
            }

            $cantidadRestituir = 0;

            if ($todo || $row->_cantidad <= 1) {
                $cantidadRestituir = (int)$row->_cantidad;
                $stmtDel = $db->prepare("DELETE FROM TCarrito WHERE _idUsuario = ? AND _idProducto = ?");
                $stmtDel->execute([$idUsuario, $idProducto]);
            } else {
                $cantidadRestituir = 1;
                $stmtUpd = $db->prepare("UPDATE TCarrito SET _cantidad = _cantidad - 1 WHERE _idUsuario = ? AND _idProducto = ?");
                $stmtUpd->execute([$idUsuario, $idProducto]);
            }

            // Devolver las unidades al stock en TProductos en tiempo real
            if ($cantidadRestituir > 0) {
                $stmtStock = $db->prepare("UPDATE TProductos SET _stock = _stock + ? WHERE _id = ?");
                $stmtStock->execute([$cantidadRestituir, $idProducto]);
            }

            $db->commit();

            return [
                'success' => true,
                'restauradas' => $cantidadRestituir
            ];
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            return ['success' => false, 'error' => 'Error al quitar del carrito: ' . $e->getMessage()];
        }
    }

    /**
     * Vacía el carrito del usuario devolviendo todo el stock reservado a los productos.
     */
    public static function vaciarYRestituir(int $idUsuario): void {
        $db = Connection::get();
        $items = self::obtenerItems($idUsuario);
        foreach ($items as $item) {
            $stmtStock = $db->prepare("UPDATE TProductos SET _stock = _stock + ? WHERE _id = ?");
            $stmtStock->execute([$item->_cantidad, $item->producto_id]);
        }
        $stmtDel = $db->prepare("DELETE FROM TCarrito WHERE _idUsuario = ?");
        $stmtDel->execute([$idUsuario]);
    }
}
