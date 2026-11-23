<?php
namespace App\Services;

use App\Database\Connection;
use PDO;

class ProductoService {
    public static function obtenerTodos(string $orden = 'DESC'): array {
        $db = Connection::get();
        $dir = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
        $stmt = $db->query("SELECT * FROM TProductos WHERE _activo = 1 ORDER BY _id $dir");
        return $stmt->fetchAll();
    }

    public static function obtenerPorId(int $id): ?object {
        $db = Connection::get();
        $stmt = $db->prepare("SELECT * FROM TProductos WHERE _id = ? AND _activo = 1 LIMIT 1");
        $stmt->execute([$id]);
        $prod = $stmt->fetch();
        return $prod ?: null;
    }

    public static function crear(array $datos): int {
        $db = Connection::get();
        $stmt = $db->prepare("
            INSERT INTO TProductos (_nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo)
            VALUES (?, ?, ?, ?, ?, ?, 1)
        ");
        $stmt->execute([
            trim($datos['nombre'] ?? ''),
            trim($datos['descripcion'] ?? ''),
            trim($datos['categoria'] ?? ''),
            (float)($datos['precio'] ?? 0),
            (int)($datos['stock'] ?? 0),
            trim($datos['imagen'] ?? ''),
        ]);
        return (int)$db->lastInsertId();
    }

    public static function actualizar(int $id, array $datos): bool {
        $db = Connection::get();
        $stmt = $db->prepare("
            UPDATE TProductos SET 
                _nombre = ?,
                _descripcion = ?,
                _categoria = ?,
                _precio = ?,
                _stock = ?,
                _imagen = ?
            WHERE _id = ?
        ");
        return $stmt->execute([
            trim($datos['nombre'] ?? ''),
            trim($datos['descripcion'] ?? ''),
            trim($datos['categoria'] ?? ''),
            (float)($datos['precio'] ?? 0),
            (int)($datos['stock'] ?? 0),
            trim($datos['imagen'] ?? ''),
            $id,
        ]);
    }

    public static function eliminar(int $id): bool {
        $db = Connection::get();
        $stmt = $db->prepare("DELETE FROM TProductos WHERE _id = ?");
        return $stmt->execute([$id]);
    }
}
