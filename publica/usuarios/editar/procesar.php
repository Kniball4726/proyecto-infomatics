<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/usuarios.php';

requerirAdmin();

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    $nombre   = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $clave    = trim($_POST['clave'] ?? '');
    $nivel    = isset($_POST['nivel']) ? (int)$_POST['nivel'] : 1;

    try {
        actualizarCliente($id, [
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'email'    => $email,
            'clave'    => $clave,
            'nivel'    => $nivel,
        ]);
        $_SESSION["mensaje"] = "Cliente #$id actualizado con éxito.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error al actualizar: " . $e->getMessage();
    }
}

header("Location: /usuarios/todos/");
exit();
