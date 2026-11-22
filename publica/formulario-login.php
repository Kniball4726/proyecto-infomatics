<?php
require_once __DIR__ . '/../includes/auth.php';
if (estaAutenticado()) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - InfoMatics</title>
    <link rel="icon" href="/recursos/logo.png" type="image/png">
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
</head>
<body>
    <header>
        <h1>Iniciar sesión en InfoMatics</h1>
        <nav>
            <button onclick="location.href='/'">← Cancelar y Volver</button>
        </nav>
    </header>
    <main>
        <?php if (!empty($_SESSION["error"])): ?>
            <p style="color: #b71c1c; font-weight: bold; background: #ffebee; padding: 10px; border-radius: 6px;"><?= htmlspecialchars($_SESSION["error"]) ?></p>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <form action="/formulario-login-procesar.php" method="POST">
            <article>
                <label for="idUsername">Email o Nombre de usuario:</label>
                <br>
                <input full type="text" name="nmUsername" id="idUsername" required autofocus>
            </article>
            <article>
                <label for="idPassword">Contraseña:</label>
                <br>
                <input full type="password" name="nmPassword" id="idPassword" required>
            </article>
            <article>
                <button full style="background-color: #d32f2f; color: #ffffff !important; font-weight: bold; padding: 10px; cursor: pointer;">
                    Iniciar sesión
                </button>
            </article>
        </form>
    </main>
</body>
</html>
