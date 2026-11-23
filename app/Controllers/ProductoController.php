<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Services\CsrfService;
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
        CsrfService::verificarOAbortar();

        $nombre = trim($datos['nombre'] ?? '');
        $precio = (float)($datos['precio'] ?? 0);

        if (empty($nombre) || $precio <= 0) {
            $_SESSION["error"] = "El nombre y un precio válido son obligatorios.";
            header("Location: /productos/nuevo/");
            exit();
        }

        $imagen = self::procesarImagen($_FILES['imagen_archivo'] ?? null, $datos['imagen'] ?? '');
        $datos['imagen'] = $imagen;

        $id = ProductoService::crear($datos);
        $_SESSION['toast'] = ['tipo' => 'success', 'mensaje' => '✓ Producto creado exitosamente.'];
        header("Location: /productos/ver/?id=" . $id);
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
        CsrfService::verificarOAbortar();

        $nombre = trim($datos['nombre'] ?? '');
        $precio = (float)($datos['precio'] ?? 0);

        if ($id <= 0 || empty($nombre) || $precio <= 0) {
            header("Location: /productos/editar/?id=" . $id);
            exit();
        }

        $prodActual = ProductoService::obtenerPorId($id);
        $imagen = self::procesarImagen($_FILES['imagen_archivo'] ?? null, $datos['imagen'] ?? '', $prodActual->_imagen ?? '');
        $datos['imagen'] = $imagen;

        ProductoService::actualizar($id, $datos);
        $_SESSION['toast'] = ['tipo' => 'success', 'mensaje' => '✓ Producto modificado correctamente.'];
        header("Location: /productos/ver/?id=" . $id);
        exit();
    }

    public static function borrar(int $id): void {
        AuthService::requerirAdmin();
        if ($id > 0) {
            ProductoService::eliminar($id);
            $_SESSION['toast'] = ['tipo' => 'info', 'mensaje' => '🗑️ Producto eliminado correctamente.'];
        }
        header("Location: /");
        exit();
    }

    public static function api(): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(ProductoService::obtenerTodos('DESC'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * Procesa la subida de una imagen física local o devuelve la URL provista.
     */
    private static function procesarImagen(?array $file, string $urlManual, string $imagenActual = ''): string {
        if ($file && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK && $file['size'] > 0) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (in_array($ext, $permitidas)) {
                $dirDestino = dirname(__DIR__, 2) . '/publica/recursos/productos';
                if (!is_dir($dirDestino)) {
                    @mkdir($dirDestino, 0777, true);
                }
                $nombreArchivo = 'prod_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $rutaDestino = $dirDestino . '/' . $nombreArchivo;
                if (move_uploaded_file($file['tmp_name'], $rutaDestino)) {
                    return '/recursos/productos/' . $nombreArchivo;
                }
            }
        }
        if (!empty(trim($urlManual))) {
            return trim($urlManual);
        }
        return $imagenActual;
    }
}
