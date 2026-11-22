<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/usuarios.php';

requerirAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cliente = obtenerUsuarioPorId($id);

if (!$cliente) {
    header("Location: /usuarios/todos/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cliente - InfoMatics</title>
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header>
        <h1>Modificar Cliente #<?= $cliente->_id ?></h1>
        <nav>
            <button onclick="location.href='/usuarios/todos/'">← Volver al listado</button>
        </nav>
    </header>
    <main>
        <?php if (!empty($_SESSION["error"])): ?>
            <p style="color: red;"><?= htmlspecialchars($_SESSION["error"]) ?></p>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <form action="/usuarios/editar/procesar.php" method="POST">
            <input type="hidden" name="id" value="<?= $cliente->_id ?>">

            <article>
                <label for="id_nombre">Nombre:</label><br>
                <input type="text" id="id_nombre" name="nombre" value="<?= htmlspecialchars($cliente->_nombre) ?>" required full>
            </article>

            <article>
                <label for="id_apellido">Apellido:</label><br>
                <input type="text" id="id_apellido" name="apellido" value="<?= htmlspecialchars($cliente->_apellido) ?>" required full>
            </article>

            <article>
                <label for="id_email">Email:</label><br>
                <input type="email" id="id_email" name="email" value="<?= htmlspecialchars($cliente->_email) ?>" required full>
            </article>

            <article>
                <label for="id_clave">Nueva Contraseña (dejar en blanco para no cambiarla):</label><br>
                <input type="password" id="id_clave" name="clave" placeholder="Ingresar solo si deseas cambiarla" full>
            </article>

            <article>
                <label for="id_nivel">Rol:</label><br>
                <select id="id_nivel" name="nivel" full>
                    <option value="1" <?= ($cliente->_nivel <= 1) ? 'selected' : '' ?>>Cliente (Nivel 1)</option>
                    <option value="10" <?= ($cliente->_nivel > 1) ? 'selected' : '' ?>>Administrador (Nivel 10)</option>
                </select>
            </article>

            <article>
                <button type="submit" style="background-color: #0277bd; color: #ffffff !important; font-weight: bold; padding: 10px 20px; cursor: pointer;">
                    Guardar Cambios
                </button>
            </article>
        </form>
    </main>
</body>
</html>
