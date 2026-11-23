<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\ProductoController;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
ProductoController::editar($id);
