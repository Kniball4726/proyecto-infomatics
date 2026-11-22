<?php
/**
 * Servicio de Productos
 */

require_once __DIR__ . '/db.php';

function obtenerProductos(string $orden = 'DESC'): array {
    $db = getDB();
    $direccion = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
    $stmt = $db->query("SELECT * FROM TProductos ORDER BY _id $direccion");
    return $stmt->fetchAll();
}

function obtenerProductoPorId(int $id): ?object {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM TProductos WHERE _id = ? LIMIT 1");
    $stmt->execute([$id]);
    $producto = $stmt->fetch();
    return $producto ?: null;
}

function crearProducto(array $datos): bool {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO TProductos (_nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    return $stmt->execute([
        $datos['nombre'] ?? '',
        $datos['descripcion'] ?? '',
        $datos['categoria'] ?? '',
        (float)($datos['precio'] ?? 0),
        (int)($datos['stock'] ?? 0),
        $datos['imagen'] ?? '',
        (int)($datos['activo'] ?? 1),
    ]);
}

function actualizarProducto(int $id, array $datos): bool {
    $db = getDB();
    $stmt = $db->prepare("
        UPDATE TProductos SET 
            _nombre = ?,
            _descripcion = ?,
            _categoria = ?,
            _precio = ?,
            _stock = ?,
            _imagen = ?,
            _activo = ?
        WHERE _id = ?
    ");
    return $stmt->execute([
        $datos['nombre'] ?? '',
        $datos['descripcion'] ?? '',
        $datos['categoria'] ?? '',
        (float)($datos['precio'] ?? 0),
        (int)($datos['stock'] ?? 0),
        $datos['imagen'] ?? '',
        (int)($datos['activo'] ?? 1),
        $id,
    ]);
}

function eliminarProducto(int $id): bool {
    $db = getDB();
    // Eliminar referencias en carrito primero
    $stmtCarrito = $db->prepare("DELETE FROM TCarrito WHERE _idProducto = ?");
    $stmtCarrito->execute([$id]);

    $stmt = $db->prepare("DELETE FROM TProductos WHERE _id = ?");
    return $stmt->execute([$id]);
}
