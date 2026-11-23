<?php
require_once __DIR__ . '/../../../app/bootstrap.php';

use App\Services\AuthService;
use App\Services\UsuarioService;

AuthService::requerirAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$encontrado = UsuarioService::obtenerPorId($id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>InfoMatics - Ver Usuario</title>
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css" />
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header>
        <h1>Viendo Usuario #<?= $id ?></h1>
        <nav>
            <button onclick="location.href='/usuarios/todos/'">← Volver al listado</button>
        </nav>
    </header>
    <section>
        <?php if (!$encontrado): ?>
            <p>No se encontró el registro #<?= $id ?></p>
        <?php else: ?>
            <p><strong>ID:</strong> <mark><?= htmlspecialchars($encontrado->_id) ?></mark></p>
            <p><strong>Nombre:</strong> <mark><?= htmlspecialchars($encontrado->_nombre) ?></mark></p>
            <p><strong>Apellido:</strong> <mark><?= htmlspecialchars($encontrado->_apellido) ?></mark></p>
            <p><strong>Email:</strong> <mark><?= htmlspecialchars($encontrado->_email) ?></mark></p>
            <p><strong>Fecha Registro:</strong> <mark><?= htmlspecialchars($encontrado->_fechaRegistro ?? 'N/A') ?></mark></p>
            <p><strong>Rol:</strong> <mark><?= ((int)$encontrado->_nivel > 1 ? 'Administrador' : 'Cliente') ?></mark></p>
        <?php endif; ?>
    </section>
</body>
</html>
