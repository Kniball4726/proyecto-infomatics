<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Services\CsrfService;
use App\Services\UsuarioService;
use App\Views\View;

class UsuarioController {
    public static function listado(): void {
        AuthService::requerirAdmin();
        $usuarios = UsuarioService::obtenerTodos();
        $mensaje = $_SESSION["mensaje"] ?? null;
        $error = $_SESSION["error"] ?? null;
        unset($_SESSION["mensaje"], $_SESSION["error"]);

        View::render('usuarios.listado', [
            'usuarios' => $usuarios,
            'mensaje'  => $mensaje,
            'error'    => $error,
        ]);
    }

    public static function nuevo(): void {
        AuthService::requerirAdmin();
        $error = $_SESSION["error"] ?? null;
        unset($_SESSION["error"]);
        View::render('usuarios.formulario_nuevo', ['error' => $error]);
    }

    public static function procesarNuevo(array $datos): void {
        AuthService::requerirAdmin();
        CsrfService::verificarOAbortar();

        $nombre = trim($datos['nombre'] ?? '');
        $email = trim($datos['email'] ?? '');

        if (empty($nombre) || empty($email)) {
            $_SESSION["error"] = "El nombre y el email son obligatorios.";
            header("Location: /usuarios/nuevo/");
            exit();
        }

        try {
            UsuarioService::crear($datos);
            $_SESSION["toast"] = ['tipo' => 'success', 'mensaje' => "✓ Cliente '$nombre' registrado con éxito."];
            header("Location: /usuarios/todos/");
            exit();
        } catch (\PDOException $e) {
            $_SESSION["error"] = "Error al crear cliente: posible correo duplicado.";
            header("Location: /usuarios/nuevo/");
            exit();
        }
    }

    public static function editar(int $id): void {
        AuthService::requerirAdmin();
        $cliente = UsuarioService::obtenerPorId($id);
        if (!$cliente) {
            header("Location: /usuarios/todos/");
            exit();
        }

        $error = $_SESSION["error"] ?? null;
        unset($_SESSION["error"]);

        View::render('usuarios.formulario_editar', [
            'cliente' => $cliente,
            'error'   => $error,
        ]);
    }

    public static function procesarEditar(int $id, array $datos): void {
        AuthService::requerirAdmin();
        CsrfService::verificarOAbortar();

        $nombre = trim($datos['nombre'] ?? '');
        $email = trim($datos['email'] ?? '');

        if ($id <= 0 || empty($nombre) || empty($email)) {
            $_SESSION["error"] = "Datos incompletos para actualizar.";
            header("Location: /usuarios/editar/?id=" . $id);
            exit();
        }

        try {
            UsuarioService::actualizar($id, $datos);
            $_SESSION["toast"] = ['tipo' => 'success', 'mensaje' => "✓ Cliente #$id modificado correctamente."];
            header("Location: /usuarios/todos/");
            exit();
        } catch (\PDOException $e) {
            $_SESSION["error"] = "Error al actualizar cliente.";
            header("Location: /usuarios/editar/?id=" . $id);
            exit();
        }
    }

    public static function borrar(int $id): void {
        AuthService::requerirAdmin();
        $currentUser = AuthService::usuarioActual();
        $currentUserId = (int)($currentUser->_id ?? $currentUser->id ?? 0);

        if ($id > 0 && $id !== $currentUserId) {
            UsuarioService::eliminar($id);
            $_SESSION["toast"] = ['tipo' => 'info', 'mensaje' => "🗑️ Cliente #$id eliminado del sistema."];
        } else {
            $_SESSION["toast"] = ['tipo' => 'error', 'mensaje' => "No puedes eliminar tu propia cuenta en uso."];
        }

        header("Location: /usuarios/todos/");
        exit();
    }

    public static function api(): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(UsuarioService::obtenerTodos(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    }
}
