<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\CarritoController;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$todo = !empty($_GET['todo']);
CarritoController::quitar($id, $todo);
