<?php
namespace App\Services;

class CsrfService {
    public static function obtenerToken(): string {
        AuthService::iniciarSesion();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function campoHtml(): string {
        $token = self::obtenerToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validar(?string $token): bool {
        AuthService::iniciarSesion();
        $guardado = $_SESSION['csrf_token'] ?? '';
        if (empty($guardado) || empty($token)) {
            return false;
        }
        return hash_equals($guardado, $token);
    }

    public static function verificarOAbortar(): void {
        $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? null;
        if (!self::validar($token)) {
            header('HTTP/1.1 403 Forbidden');
            echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>403 Solicitud Inválida</title></head><body style='font-family: sans-serif; text-align: center; padding: 3rem;'><h1>403 Solicitud no válida (CSRF)</h1><p>El token de seguridad ha expirado o es inválido. Por favor, regresa e intenta nuevamente.</p><p><a href='/' style='color: #d32f2f; font-weight: bold;'>Volver al inicio</a></p></body></html>";
            exit();
        }
    }
}
