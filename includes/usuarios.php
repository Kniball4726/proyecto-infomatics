<?php
/**
 * Servicio de Gestión de Usuarios y Clientes
 */

require_once __DIR__ . '/db.php';

function obtenerUsuarios(bool $soloClientes = false): array {
    $db = getDB();
    if ($soloClientes) {
        $stmt = $db->query("SELECT * FROM TUsuarios WHERE _nivel = 1 ORDER BY _id DESC");
    } else {
        $stmt = $db->query("SELECT * FROM TUsuarios ORDER BY _id DESC");
    }
    return $stmt->fetchAll();
}

function obtenerUsuarioPorId(int $id): ?object {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM TUsuarios WHERE _id = ? LIMIT 1");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function crearCliente(array $datos): bool {
    $db = getDB();
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

function actualizarCliente(int $id, array $datos): bool {
    $db = getDB();
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

function eliminarCliente(int $id): bool {
    $db = getDB();
    // Eliminar carrito asociado del cliente primero
    $stmtCarrito = $db->prepare("DELETE FROM TCarrito WHERE _idUsuario = ?");
    $stmtCarrito->execute([$id]);

    $stmt = $db->prepare("DELETE FROM TUsuarios WHERE _id = ?");
    return $stmt->execute([$id]);
}
