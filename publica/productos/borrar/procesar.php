<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\ProductoController;

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
ProductoController::borrar($id);
