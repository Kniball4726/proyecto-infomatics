<?php
require_once __DIR__ . '/../../../includes/auth.php';

$nombre   = trim($_REQUEST['nm_nombre'] ?? '');
$apellido = trim($_REQUEST['nm_apellido'] ?? '');
$email    = trim($_REQUEST['nm_email'] ?? '');
$clave    = trim($_REQUEST['nm_clave'] ?? '');

if (!empty($email) && !empty($clave)) {
    try {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO TUsuarios (_nombre, _apellido, _email, _clave, _nivel)
            VALUES (?, ?, ?, ?, 1)
        ");
        $stmt->execute([$nombre, $apellido, $email, $clave]);
        $_SESSION["mensaje"] = "Usuario registrado con éxito. Ya puedes iniciar sesión.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error al registrar usuario: " . $e->getMessage();
    }
}

header("Location: ./index.php");
exit();
