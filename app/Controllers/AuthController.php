<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Views\View;

class AuthController {
    public static function login(): void {
        AuthService::iniciarSesion();
        if (AuthService::estaAutenticado()) {
            header("Location: /");
            exit();
        }

        $error = $_SESSION["error"] ?? null;
        unset($_SESSION["error"]);

        View::render('auth.login', ['error' => $error]);
    }

    public static function procesarLogin(): void {
        AuthService::iniciarSesion();
        $usuario = trim($_POST['nmUsername'] ?? '');
        $clave = trim($_POST['nmPassword'] ?? '');

        if (empty($usuario) || empty($clave)) {
            $_SESSION["error"] = "Debes ingresar tu usuario y contraseña.";
            header("Location: /formulario-login.php");
            exit();
        }

        if (AuthService::autenticar($usuario, $clave)) {
            header("Location: /");
            exit();
        } else {
            $_SESSION["error"] = "Credenciales incorrectas. Verifica tu correo/usuario y clave.";
            header("Location: /formulario-login.php");
            exit();
        }
    }

    public static function logout(): void {
        AuthService::cerrarSesion();
        header("Location: /");
        exit();
    }
}
