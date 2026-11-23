<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\PedidoController;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
PedidoController::ver($id);
