<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/productos.php';

requerirAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$producto = obtenerProductoPorId($id);

if (!$producto) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto - InfoMatics</title>
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header>
        <h1>Modificar Producto #<?= $producto->_id ?></h1>
        <nav>
            <button onclick="location.href='/productos/ver?id=<?= $producto->_id ?>'">← Volver al producto</button>
        </nav>
    </header>
    <main>
        <form action="/productos/editar/procesar.php" method="POST">
            <input type="hidden" name="id" value="<?= $producto->_id ?>">

            <article>
                <label for="id_nombre">Nombre del producto:</label><br>
                <input type="text" id="id_nombre" name="nombre" value="<?= htmlspecialchars($producto->_nombre) ?>" required full>
            </article>

            <article>
                <label for="id_descripcion">Descripción:</label><br>
                <textarea id="id_descripcion" name="descripcion" full><?= htmlspecialchars($producto->_descripcion ?? '') ?></textarea>
            </article>

            <article>
                <label for="id_categoria">Categoría:</label><br>
                <input type="text" id="id_categoria" name="categoria" value="<?= htmlspecialchars($producto->_categoria) ?>" required full>
            </article>

            <article>
                <label for="id_precio">Precio ($):</label><br>
                <input type="number" id="id_precio" name="precio" step="0.01" value="<?= $producto->_precio ?>" required full>
            </article>

            <article>
                <label for="id_stock">Stock:</label><br>
                <input type="number" id="id_stock" name="stock" value="<?= $producto->_stock ?>" required full>
            </article>

            <article>
                <label for="id_imagen">URL de la Imagen:</label><br>
                <input type="text" id="id_imagen" name="imagen" value="<?= htmlspecialchars($producto->_imagen ?? '') ?>" full>
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
