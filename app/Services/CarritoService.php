<?php
namespace App\Services;

use App\Database\Connection;
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

    public static function agregar(int $idUsuario, int $idProducto, int $cantidad = 1): bool {
        if ($idUsuario <= 0 || $idProducto <= 0 || $cantidad <= 0) {
            return false;
        }
        $db = Connection::get();
        $stmt = $db->prepare("
            INSERT INTO TCarrito (_idUsuario, _idProducto, _cantidad)
            VALUES (?, ?, ?)
            ON CONFLICT(_idUsuario, _idProducto) 
            DO UPDATE SET _cantidad = _cantidad + excluded._cantidad
        ");
        return $stmt->execute([$idUsuario, $idProducto, $cantidad]);
    }

    public static function quitar(int $idUsuario, int $idProducto, bool $todo = false): bool {
        if ($idUsuario <= 0 || $idProducto <= 0) {
            return false;
        }
        $db = Connection::get();

        if ($todo) {
            $stmt = $db->prepare("DELETE FROM TCarrito WHERE _idUsuario = ? AND _idProducto = ?");
            return $stmt->execute([$idUsuario, $idProducto]);
        }

        // Obtener cantidad actual
        $stmt = $db->prepare("SELECT _cantidad FROM TCarrito WHERE _idUsuario = ? AND _idProducto = ?");
        $stmt->execute([$idUsuario, $idProducto]);
        $row = $stmt->fetch();

        if (!$row) {
            return false;
        }

        if ($row->_cantidad <= 1) {
            $stmtDel = $db->prepare("DELETE FROM TCarrito WHERE _idUsuario = ? AND _idProducto = ?");
            return $stmtDel->execute([$idUsuario, $idProducto]);
        } else {
            $stmtUpd = $db->prepare("UPDATE TCarrito SET _cantidad = _cantidad - 1 WHERE _idUsuario = ? AND _idProducto = ?");
            return $stmtUpd->execute([$idUsuario, $idProducto]);
        }
    }
}
