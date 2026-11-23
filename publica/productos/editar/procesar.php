<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\ProductoController;

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
ProductoController::procesarEditar($id, $_POST);
