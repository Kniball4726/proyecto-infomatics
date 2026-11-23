<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\UsuarioController;

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
UsuarioController::borrar($id);
