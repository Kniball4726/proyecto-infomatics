<?php
require_once __DIR__ . '/../../../includes/auth.php';

requerirAdmin();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Cliente - InfoMatics</title>
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header>
        <h1>Registrar Nuevo Cliente</h1>
        <nav>
            <button onclick="location.href='/usuarios/todos/'">← Volver al listado</button>
        </nav>
    </header>
    <main>
        <?php if (!empty($_SESSION["error"])): ?>
            <p style="color: red;"><?= htmlspecialchars($_SESSION["error"]) ?></p>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <form action="/usuarios/nuevo/procesar.php" method="POST">
            <article>
                <label for="id_nombre">Nombre:</label><br>
                <input type="text" id="id_nombre" name="nombre" required full>
            </article>

            <article>
                <label for="id_apellido">Apellido:</label><br>
                <input type="text" id="id_apellido" name="apellido" required full>
            </article>

            <article>
                <label for="id_email">Email:</label><br>
                <input type="email" id="id_email" name="email" required full>
            </article>

            <article>
                <label for="id_clave">Contraseña:</label><br>
                <input type="password" id="id_clave" name="clave" required full>
            </article>

            <article>
                <label for="id_nivel">Rol:</label><br>
                <select id="id_nivel" name="nivel" full>
                    <option value="1" selected>Cliente (Nivel 1)</option>
                    <option value="10">Administrador (Nivel 10)</option>
                </select>
            </article>

            <article>
                <button type="submit" style="background-color: #2e7d32; color: #ffffff !important; font-weight: bold; padding: 10px 20px; cursor: pointer;">
                    Crear Cliente
                </button>
            </article>
        </form>
    </main>
</body>
</html>
