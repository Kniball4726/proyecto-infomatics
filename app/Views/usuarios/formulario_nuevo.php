<?php
/** @var string|null $error */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = 'Nuevo Cliente - InfoMatics';
    require __DIR__ . '/../layout/head.php'; 
    ?>
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
        <h1 style="margin: 0;">Registrar Nuevo Cliente</h1>
        <nav style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='/usuarios/todos/'">← Volver al listado</button>
        </nav>
    </header>
    <main>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/usuarios/nuevo/procesar.php" method="POST">
            <?= \App\Services\CsrfService::campoHtml() ?>
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
                <button type="submit" class="btn btn-success">
                    ✓ Crear Cliente
                </button>
            </article>
        </form>
    </main>
</body>
</html>
