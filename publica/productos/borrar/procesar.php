<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/productos.php';

requerirAdmin();

$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($id > 0) {
    eliminarProducto($id);
}

header("Location: /");
exit();
