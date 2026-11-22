<?php
/**
 * Servicio de Carrito de Compras
 */

require_once __DIR__ . '/db.php';

function obtenerResumenCarrito(int $idUsuario): object {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT 
            COALESCE(SUM(c._cantidad), 0) AS total_items,
            COALESCE(SUM(c._cantidad * p._precio), 0) AS total_precio
        FROM TCarrito c
        JOIN TProductos p ON c._idProducto = p._id
        WHERE c._idUsuario = ?
    ");
    $stmt->execute([$idUsuario]);
    $res = $stmt->fetch();
    return (object)[
        'total_items'  => (int)($res->total_items ?? 0),
        'total_precio' => (float)($res->total_precio ?? 0.0),
    ];
}

function obtenerItemsCarrito(int $idUsuario): array {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT 
            c._id AS _idCarrito,
            c._idProducto,
            c._cantidad,
            p._nombre,
            p._descripcion,
            p._precio,
            p._imagen,
            (c._cantidad * p._precio) AS _subtotal
        FROM TCarrito c
        JOIN TProductos p ON c._idProducto = p._id
        WHERE c._idUsuario = ?
        ORDER BY c._id DESC
    ");
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll();
}

function agregarAlCarrito(int $idUsuario, int $idProducto, int $cantidad = 1): bool {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO TCarrito (_idUsuario, _idProducto, _cantidad)
        VALUES (?, ?, ?)
        ON CONFLICT(_idUsuario, _idProducto) DO UPDATE SET _cantidad = _cantidad + ?
    ");
    return $stmt->execute([$idUsuario, $idProducto, $cantidad, $cantidad]);
}

function quitarDelCarrito(int $idUsuario, int $idProducto, bool $eliminarTodo = false): bool {
    $db = getDB();
    $stmt = $db->prepare("SELECT _id, _cantidad FROM TCarrito WHERE _idUsuario = ? AND _idProducto = ? LIMIT 1");
    $stmt->execute([$idUsuario, $idProducto]);
    $item = $stmt->fetch();

    if (!$item) {
        return false;
    }

    if ($eliminarTodo || $item->_cantidad <= 1) {
        $del = $db->prepare("DELETE FROM TCarrito WHERE _id = ?");
        return $del->execute([$item->_id]);
    }

    $upd = $db->prepare("UPDATE TCarrito SET _cantidad = _cantidad - 1 WHERE _id = ?");
    return $upd->execute([$item->_id]);
}
