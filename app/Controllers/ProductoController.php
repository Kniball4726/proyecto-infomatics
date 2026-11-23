<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Services\ProductoService;
use App\Views\View;

class ProductoController {
    public static function catalogo(): void {
        AuthService::iniciarSesion();
        $productos = ProductoService::obtenerTodos('DESC');
        View::render('productos.catalogo', ['productos' => $productos]);
    }

    public static function ver(int $id): void {
        AuthService::iniciarSesion();
        $id = $id > 0 ? $id : 1;
        $producto = ProductoService::obtenerPorId($id);
        View::render('productos.detalle', ['producto' => $producto]);
    }

    public static function nuevo(): void {
        AuthService::requerirAdmin();
        $error = $_SESSION["error"] ?? null;
        unset($_SESSION["error"]);
        View::render('productos.formulario_nuevo', ['error' => $error]);
    }

    public static function procesarNuevo(array $datos): void {
        AuthService::requerirAdmin();
        $nombre = trim($datos['nombre'] ?? '');
        $precio = (float)($datos['precio'] ?? 0);

        if (empty($nombre) || $precio <= 0) {
            $_SESSION["error"] = "El nombre y un precio válido son obligatorios.";
            header("Location: /productos/nuevo/");
            exit();
        }

        $id = ProductoService::crear($datos);
        header("Location: /productos/ver?id=" . $id);
        exit();
    }

    public static function editar(int $id): void {
        AuthService::requerirAdmin();
        $producto = ProductoService::obtenerPorId($id);
        if (!$producto) {
            header("Location: /");
            exit();
        }
        View::render('productos.formulario_editar', ['producto' => $producto]);
    }

    public static function procesarEditar(int $id, array $datos): void {
        AuthService::requerirAdmin();
        $nombre = trim($datos['nombre'] ?? '');
        $precio = (float)($datos['precio'] ?? 0);

        if ($id <= 0 || empty($nombre) || $precio <= 0) {
            header("Location: /productos/editar/?id=" . $id);
            exit();
        }

        ProductoService::actualizar($id, $datos);
        header("Location: /productos/ver?id=" . $id);
        exit();
    }

    public static function borrar(int $id): void {
        AuthService::requerirAdmin();
        if ($id > 0) {
            ProductoService::eliminar($id);
        }
        header("Location: /");
        exit();
    }

    public static function api(): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(ProductoService::obtenerTodos('DESC'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    }
}
