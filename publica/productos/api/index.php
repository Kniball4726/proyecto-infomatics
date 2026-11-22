<?php
require_once __DIR__ . '/../../../includes/productos.php';

header("Content-Type: application/json; charset=utf-8");
$todos = obtenerProductos('DESC');
echo json_encode($todos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
