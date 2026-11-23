<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\CarritoController;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cantidad = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 1;
CarritoController::agregar($id, $cantidad);
