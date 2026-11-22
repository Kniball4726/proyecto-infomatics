<?php
require_once __DIR__ . '/../../../includes/auth.php';
requerirAdmin();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - InfoMatics</title>
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header>
        <h1>Insertar nuevo producto</h1>
        <?php if (!empty($_SESSION["error"])): ?>
            <p style="color: red;"><?= htmlspecialchars($_SESSION["error"]) ?></p>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>
        <nav>
            <button onclick="location.href='/'">← Volver al catálogo</button>
        </nav>
    </header>
    <main>
        <form action="/productos/nuevo/procesar.php" method="POST">
            <article>
                <label for="id_nombre">Nombre del producto:</label><br>
                <input type="text" id="id_nombre" name="nombre" required full>
            </article>

            <article>
                <label for="id_descripcion">Descripción:</label><br>
                <textarea id="id_descripcion" name="descripcion" full></textarea>
            </article>

            <article>
                <label for="id_categoria">Categoría:</label><br>
                <input type="text" id="id_categoria" name="categoria" required full>
            </article>

            <article>
                <label for="id_precio">Precio ($):</label><br>
                <input type="number" id="id_precio" name="precio" step="0.01" required full>
            </article>

            <article>
                <label for="id_stock">Stock disponible:</label><br>
                <input type="number" id="id_stock" name="stock" required value="10" full>
            </article>

            <article>
                <label for="id_imagen">URL de la Imagen (opcional):</label><br>
                <input type="url" id="id_imagen" name="imagen" full>
            </article>

            <article>
                <button type="submit" style="background-color: #2e7d32; color: #ffffff !important; font-weight: bold; padding: 10px 20px; cursor: pointer;">
                    Guardar Producto
                </button>
            </article>
        </form>
    </main>
</body>
</html>
