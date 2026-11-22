<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/usuarios.php';

requerirAdmin();

$nombre   = trim($_POST['nombre'] ?? $_GET['nm_nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? $_GET['nm_apellido'] ?? '');
$email    = trim($_POST['email'] ?? $_GET['nm_email'] ?? '');
$clave    = trim($_POST['clave'] ?? $_GET['nm_clave'] ?? '');
$nivel    = isset($_POST['nivel']) ? (int)$_POST['nivel'] : 1;

if (!empty($nombre) && !empty($email) && !empty($clave)) {
    try {
        crearCliente([
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'email'    => $email,
            'clave'    => $clave,
            'nivel'    => $nivel,
        ]);
        $_SESSION["mensaje"] = "Cliente '$nombre $apellido' creado con éxito.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error al crear cliente: " . $e->getMessage();
    }
}

header("Location: /usuarios/todos/");
exit();
