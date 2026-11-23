<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\UsuarioController;

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
UsuarioController::procesarEditar($id, $_POST);
