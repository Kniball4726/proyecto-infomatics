<?php
require_once __DIR__ . '/../includes/auth.php';

$username = trim($_REQUEST['nmUsername'] ?? '');
$password = trim($_REQUEST['nmPassword'] ?? '');

if (autenticarUsuario($username, $password)) {
    header("Location: /");
} else {
    header("Location: /formulario-login.php");
}
exit();
