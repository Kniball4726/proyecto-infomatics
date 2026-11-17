<?php
    session_start();
    $mensaje = $_SESSION["mensaje"] ?? null;
    $error = $_SESSION["error"] ?? null;
    unset($_SESSION["mensaje"], $_SESSION["error"]);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Agregar usuario - InfoMatics</title>
        <meta name="viewport" content="width=device-width,user-scalable=no" />
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css" />
        <style>[full]{ width: 100%; }</style>
    </head>
    <body>
        <header>
            <h1>Insertar un/a nuev@ usuari@</h1>
            <?php if ($mensaje): ?>
                <p id="idMarcaMensaje"><strong><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></strong></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p id="idMarcaError" class="error"><strong><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></strong></p>
            <?php endif; ?>
            <nav>
                <button type="button" onclick="location.href='/usuarios'">Volver</button>
            </nav>
        </header>
        <form action="/usuarios/nuevo/procesar.php" method="post">
            <article>
                <label for="id_nombre">Nombre:</label><br>
                <input type="text" id="id_nombre" name="nm_nombre" required />
            </article>

            <article>
                <label for="id_apellido">Apellido:</label><br>
                <input type="text" id="id_apellido" name="nm_apellido" required />
            </article>

            <article>
                <label for="id_email">Email:</label><br>
                <input type="email" id="id_email" name="nm_email" required />
            </article>

            <article>
                <label for="id_clave">Contraseña:</label><br>
                <input type="password" id="id_clave" name="nm_clave" required />
            </article>

            <article>
                <label for="id_nivel">Nivel de usuario:</label><br>
                <select id="id_nivel" name="nm_nivel" required>
                    <option value="1" selected>Usuario estándar (1)</option>
                    <option value="10">Administrador (10)</option>
                </select>
            </article>

            <input type="submit" value="Agregar nuevo usuario" />
        </form>
    </body>
</html>