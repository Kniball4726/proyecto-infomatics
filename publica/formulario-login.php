<?php
    session_start();
    if (isset($_SESSION["usuario"])) {
        header("Location: /");
        exit();
    }
    $error = $_SESSION["error"] ?? null;
    $mensaje = $_SESSION["mensaje"] ?? null;
    unset($_SESSION["error"], $_SESSION["mensaje"]);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>InfoMatics Login</title>
        <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
        <style>[full]{ width: 100%; }</style>
    </head>
    <body>
        <header>
            <h1>Iniciar sesión en InfoMatics</h1>
            <nav>
                <button type="button" onclick="location.href='/'">Cancelar</button>
            </nav>
        </header>
        <?php if ($error): ?>
            <article id="idMarcaError">
                <p class="error"><strong><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></strong></p>
            </article>
        <?php endif; ?>
        <?php if ($mensaje): ?>
            <article id="idMarcaMensaje">
                <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
            </article>
        <?php endif; ?>
        <form action="/formulario-login-procesar.php" method="post">
            <article>
                <label for="idUsername">Email:</label>
                <br>
                <input full type="email" name="nmUsername" id="idUsername" autocomplete="email" required autofocus>
            </article>
            <article>
                <label for="idPassword">Contraseña:</label>
                <br>
                <input full type="password" name="nmPassword" id="idPassword" autocomplete="current-password" required>
            </article>
            <article>
                <button full type="submit">Iniciar sesión</button>
            </article>
        </form>
    </body>
</html>