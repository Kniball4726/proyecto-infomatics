<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/productos.php';

requerirAdmin();

$datos = [
    'nombre'      => trim($_POST['nombre'] ?? $_GET['nm_nombre'] ?? ''),
    'descripcion' => trim($_POST['descripcion'] ?? $_GET['nm_descripcion'] ?? ''),
    'categoria'   => trim($_POST['categoria'] ?? $_GET['nm_categoria'] ?? ''),
    'precio'      => (float)($_POST['precio'] ?? $_GET['nm_precio'] ?? 0),
    'stock'       => (int)($_POST['stock'] ?? $_GET['nm_stock'] ?? 0),
    'imagen'      => trim($_POST['imagen'] ?? $_GET['nm_imagen'] ?? ''),
    'activo'      => 1,
];

if (!empty($datos['nombre'])) {
    crearProducto($datos);
}

header("Location: /");
exit();
