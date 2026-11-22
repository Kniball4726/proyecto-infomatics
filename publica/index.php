<?php
require_once __DIR__ . '/../includes/layout.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('InfoMatics Computación - Tienda Online'); ?>
</head>
<body>
    <?php renderHeaderCompleto(); ?>

    <main id="idListaProductos">
        <?php include __DIR__ . "/productos/todos/index.php"; ?>
    </main>
</body>
</html>
