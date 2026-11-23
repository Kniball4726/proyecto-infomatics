<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Controllers\UsuarioController;

UsuarioController::procesarNuevo($_POST);
