<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/usuarios.php';

requerirAdmin();

$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
$currentUser = usuarioActual();

if ($id > 0) {
    if ($currentUser && $currentUser->id == $id) {
        $_SESSION["error"] = "No puedes eliminar tu propia cuenta de administrador mientras tienes la sesión iniciada.";
    } else {
        eliminarCliente($id);
        $_SESSION["mensaje"] = "Cliente eliminado con éxito.";
    }
}

header("Location: /usuarios/todos/");
exit();
