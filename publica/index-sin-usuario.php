<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>InfoMatics Computación</title>
        <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=brown">
    </head>
    <body>
        <header>
            <h1>
                InfoMatics
            </h1>
            <nav>
                <button onclick="location.href='/formulario-login.php'" >
                    Iniciar sesión
                </button>
            </nav>
        </header>
        <div id="idListaProductos" >
<?php include "./productos/todos/index.php" ?>
        </div>
    </body>
</html>