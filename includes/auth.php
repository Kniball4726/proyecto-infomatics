<?php
/**
 * Servicio de Autenticación, Roles y Sesión
 */

require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaAutenticado(): bool {
    return isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"]);
}

function esAdmin(): bool {
    return estaAutenticado() && isset($_SESSION["nivel"]) && (int)$_SESSION["nivel"] > 1;
}

function esCliente(): bool {
    return estaAutenticado() && (!isset($_SESSION["nivel"]) || (int)$_SESSION["nivel"] <= 1);
}

function usuarioActual(): ?object {
    if (!estaAutenticado()) {
        return null;
    }
    return (object)[
        'id'     => $_SESSION["usuario"],
        'email'  => $_SESSION["email"] ?? '',
        'nombre' => $_SESSION["nombre"] ?? 'Usuario',
        'nivel'  => (int)($_SESSION["nivel"] ?? 1),
    ];
}

function requerirAuth(string $redirigirA = '/formulario-login.php'): void {
    if (!estaAutenticado()) {
        header("Location: $redirigirA");
        exit();
    }
}

function requerirAdmin(string $redirigirA = '/'): void {
    if (!esAdmin()) {
        header("Location: $redirigirA");
        exit();
    }
}

function requerirCliente(string $redirigirA = '/'): void {
    if (!esCliente()) {
        header("Location: $redirigirA");
        exit();
    }
}

function autenticarUsuario(string $identificador, string $clave): bool {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT * FROM TUsuarios 
        WHERE (_email = ? OR _nombre = ?) AND _clave = ?
        LIMIT 1
    ");
    $stmt->execute([$identificador, $identificador, $clave]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $_SESSION["usuario"] = $usuario->_id;
        $_SESSION["email"]   = $usuario->_email;
        $_SESSION["nombre"]  = $usuario->_nombre;
        $_SESSION["nivel"]   = (int)$usuario->_nivel;
        unset($_SESSION["error"]);
        return true;
    }

    $_SESSION["error"] = "Error: Usuario o contraseña incorrectos";
    return false;
}

function cerrarSesion(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION = [];
    session_destroy();
}
