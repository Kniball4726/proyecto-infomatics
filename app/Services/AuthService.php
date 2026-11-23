<?php
namespace App\Services;

use App\Database\Connection;
use PDO;

class AuthService {
    public static function iniciarSesion(): void {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
    }

    public static function autenticar(string $usuarioOEmail, string $clave): bool {
        self::iniciarSesion();
        $db = Connection::get();
        $stmt = $db->prepare("
            SELECT * FROM TUsuarios 
            WHERE (_email = ? OR _nombre = ?) AND _clave = ?
            LIMIT 1
        ");
        $stmt->execute([$usuarioOEmail, $usuarioOEmail, $clave]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION["usuario"] = $user;
            return true;
        }
        return false;
    }

    public static function cerrarSesion(): void {
        self::iniciarSesion();
        session_unset();
        session_destroy();
    }

    public static function estaAutenticado(): bool {
        self::iniciarSesion();
        return !empty($_SESSION["usuario"]);
    }

    public static function usuarioActual(): ?object {
        self::iniciarSesion();
        return $_SESSION["usuario"] ?? null;
    }

    public static function esAdmin(): bool {
        $user = self::usuarioActual();
        return $user && (int)($user->_nivel ?? 0) > 1;
    }

    public static function esCliente(): bool {
        $user = self::usuarioActual();
        return $user && (int)($user->_nivel ?? 0) === 1;
    }

    public static function requerirAuth(): void {
        if (!self::estaAutenticado()) {
            $_SESSION["error"] = "Debes iniciar sesión para continuar.";
            header("Location: /formulario-login.php");
            exit();
        }
    }

    public static function requerirAdmin(): void {
        self::requerirAuth();
        if (!self::esAdmin()) {
            header("HTTP/1.1 403 Forbidden");
            echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>403 Acceso Denegado</title></head><body><h1>403 Acceso Denegado</h1><p>Esta sección requiere permisos de administrador.</p><p><a href='/'>Volver a la tienda</a></p></body></html>";
            exit();
        }
    }

    public static function requerirCliente(): void {
        self::requerirAuth();
        if (!self::esCliente()) {
            header("Location: /");
            exit();
        }
    }
}
