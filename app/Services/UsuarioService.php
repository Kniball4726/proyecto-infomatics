<?php
namespace App\Services;

use App\Database\Connection;
use PDO;

class UsuarioService {
    public static function obtenerTodos(bool $soloClientes = false): array {
        $db = Connection::get();
        if ($soloClientes) {
            $stmt = $db->query("SELECT * FROM TUsuarios WHERE _nivel = 1 ORDER BY _id DESC");
        } else {
            $stmt = $db->query("SELECT * FROM TUsuarios ORDER BY _id DESC");
        }
        return $stmt->fetchAll();
    }

    public static function obtenerPorId(int $id): ?object {
        $db = Connection::get();
        $stmt = $db->prepare("SELECT * FROM TUsuarios WHERE _id = ? LIMIT 1");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function crear(array $datos): bool {
        $db = Connection::get();
        $stmt = $db->prepare("
            INSERT INTO TUsuarios (_nombre, _apellido, _email, _clave, _nivel)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            trim($datos['nombre'] ?? ''),
            trim($datos['apellido'] ?? ''),
            trim($datos['email'] ?? ''),
            trim($datos['clave'] ?? '123456'),
            (int)($datos['nivel'] ?? 1),
        ]);
    }

    public static function actualizar(int $id, array $datos): bool {
        $db = Connection::get();
        if (!empty($datos['clave'])) {
            $stmt = $db->prepare("
                UPDATE TUsuarios SET 
                    _nombre = ?,
                    _apellido = ?,
                    _email = ?,
                    _clave = ?,
                    _nivel = ?
                WHERE _id = ?
            ");
            return $stmt->execute([
                trim($datos['nombre'] ?? ''),
                trim($datos['apellido'] ?? ''),
                trim($datos['email'] ?? ''),
                trim($datos['clave'] ?? ''),
                (int)($datos['nivel'] ?? 1),
                $id,
            ]);
        } else {
            $stmt = $db->prepare("
                UPDATE TUsuarios SET 
                    _nombre = ?,
                    _apellido = ?,
                    _email = ?,
                    _nivel = ?
                WHERE _id = ?
            ");
            return $stmt->execute([
                trim($datos['nombre'] ?? ''),
                trim($datos['apellido'] ?? ''),
                trim($datos['email'] ?? ''),
                (int)($datos['nivel'] ?? 1),
                $id,
            ]);
        }
    }

    public static function eliminar(int $id): bool {
        $db = Connection::get();
        // Eliminar también posibles carritos asociados
        $stmtCart = $db->prepare("DELETE FROM TCarrito WHERE _idUsuario = ?");
        $stmtCart->execute([$id]);

        $stmt = $db->prepare("DELETE FROM TUsuarios WHERE _id = ?");
        return $stmt->execute([$id]);
    }
}
