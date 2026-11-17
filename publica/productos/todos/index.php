<?php
    $esInclusion = count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)) > 0;
    if (!$esInclusion && session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $base = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/../infomatics.db");
    $reglaSQL = "SELECT * FROM TProductos;";
    $accion = $base->query($reglaSQL);

    if (!$esInclusion):
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Productos - InfoMatics</title>
        <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
        <style>[full]{ width: 100%; }</style>
    </head>
    <body>
        <header>
            <h1>Viendo los productos</h1>
            <nav>
                <button onclick="location.href='/';">Volver</button>
                <button onclick="location.href='/productos/nuevo/';">Agregar nuevo producto</button>
            </nav>
        </header>
<?php
    endif;

    if (!$accion):
        printf("<p class='error'>%s</p><details>%s</details>", "No hay ningún registro en la tabla", $base->errorInfo()[2]);
    else:
        $todos = $accion->fetchAll(PDO::FETCH_OBJ);
        printf("<p>En total hay %d productos</p>", count($todos));
        foreach ($todos as $cadaRegistro):
            include __DIR__ . "/render.php";
        endforeach;
    endif;

    if (!$esInclusion):
?>
    </body>
</html>
<?php
    endif;
