<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Services\CsrfService;
use App\Services\UsuarioService;
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
        CsrfService::verificarOAbortar();

        $usuario = trim($_POST['nmUsername'] ?? '');
        $clave = trim($_POST['nmPassword'] ?? '');

        if (empty($usuario) || empty($clave)) {
            $_SESSION["error"] = "Debes ingresar tu usuario y contraseña.";
            header("Location: /formulario-login.php");
            exit();
        }

        if (AuthService::autenticar($usuario, $clave)) {
            $_SESSION['toast'] = ['tipo' => 'success', 'mensaje' => '¡Sesión iniciada con éxito!'];
            header("Location: /");
            exit();
        } else {
            $_SESSION["error"] = "Credenciales incorrectas. Verifica tu correo/usuario y clave.";
            header("Location: /formulario-login.php");
            exit();
        }
    }

    public static function registro(): void {
        AuthService::iniciarSesion();
        if (AuthService::estaAutenticado()) {
            header("Location: /");
            exit();
        }

        $error = $_SESSION["error_registro"] ?? null;
        $datos = $_SESSION["datos_registro"] ?? [];
        unset($_SESSION["error_registro"], $_SESSION["datos_registro"]);

        View::render('auth.registro', ['error' => $error, 'datos' => $datos]);
    }

    public static function procesarRegistro(): void {
        AuthService::iniciarSesion();
        CsrfService::verificarOAbortar();

        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $clave = trim($_POST['clave'] ?? '');
        $claveConfirm = trim($_POST['clave_confirmar'] ?? '');

        $_SESSION["datos_registro"] = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email
        ];

        if (empty($nombre) || empty($apellido) || empty($email) || empty($clave)) {
            $_SESSION["error_registro"] = "Por favor, completa todos los campos obligatorios.";
            header("Location: /registro.php");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error_registro"] = "El correo electrónico ingresado no tiene un formato válido.";
            header("Location: /registro.php");
            exit();
        }

        if (strlen($clave) < 4) {
            $_SESSION["error_registro"] = "La contraseña debe tener al menos 4 caracteres.";
            header("Location: /registro.php");
            exit();
        }

        if ($clave !== $claveConfirm) {
            $_SESSION["error_registro"] = "Las contraseñas no coinciden. Por favor verifícalas.";
            header("Location: /registro.php");
            exit();
        }

        if (UsuarioService::emailExiste($email)) {
            $_SESSION["error_registro"] = "El correo ya se encuentra registrado. ¿Deseas iniciar sesión?";
            header("Location: /registro.php");
            exit();
        }

        $exito = UsuarioService::crear([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'clave' => $clave,
            'nivel' => 1 // Rol Cliente
        ]);

        if ($exito) {
            unset($_SESSION["datos_registro"]);
            AuthService::autenticar($email, $clave);
            $_SESSION['toast'] = ['tipo' => 'success', 'mensaje' => '¡Bienvenido a InfoMatics! Tu cuenta fue creada exitosamente.'];
            header("Location: /");
            exit();
        } else {
            $_SESSION["error_registro"] = "Ocurrió un error al registrar la cuenta. Inténtalo de nuevo.";
            header("Location: /registro.php");
            exit();
        }
    }

    public static function logout(): void {
        AuthService::cerrarSesion();
        AuthService::iniciarSesion();
        $_SESSION['toast'] = ['tipo' => 'info', 'mensaje' => 'Has cerrado tu sesión correctamente.'];
        header("Location: /");
        exit();
    }
}
