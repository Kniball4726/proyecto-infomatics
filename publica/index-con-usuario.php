<?php
    $nombreUsuario = $_SESSION["nickname"] ?? $_SESSION["email"] ?? "Usuario";
    $esAdmin = $esUsuarioAdmin ?? (($_SESSION["nivel"] ?? 0) >= 10);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>InfoMatics Computación</title>
        <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
    </head>
    <body>
        <header>
            <h1>
                InfoMatics
            </h1>
            <p>Sesión iniciada como <strong><?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?></strong></p>
            <nav>
                <button onclick="location.href='/carrito/todos';">
                    Ver carrito
                </button>
                <?php if ($esAdmin): ?>
                    <button onclick="location.href='/productos/';">
                        Productos
                    </button>
                    <button onclick="location.href='/usuarios/';">
                        Usuarios
                    </button>
                <?php endif; ?>
                <button onclick="location.href='/formulario-logout.php'" >
                    Cerrar sesión
                </button>
            </nav>
        </header>
        <div id="idListaProductos" >
<?php include "./productos/todos/index.php" ?>
        </div>
    </body>
</html>