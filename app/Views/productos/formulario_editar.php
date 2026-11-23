<?php
/** @var object $producto */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = 'Modificar Producto - InfoMatics';
    require __DIR__ . '/../layout/head.php'; 
    ?>
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
        <h1 style="margin: 0;">Modificar Producto #<?= $producto->_id ?></h1>
        <nav style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='/productos/ver?id=<?= $producto->_id ?>'">← Volver al producto</button>
        </nav>
    </header>
    <main>
        <form action="/productos/editar/procesar.php" method="POST" enctype="multipart/form-data">
            <?= \App\Services\CsrfService::campoHtml() ?>
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

            <?php if (!empty($producto->_imagen)): ?>
                <article style="text-align: center; background: rgba(0,0,0,0.02); padding: 10px;">
                    <label>Imagen Actual:</label><br>
                    <img src="<?= htmlspecialchars($producto->_imagen) ?>" alt="Preview" style="max-height: 100px; max-width: 100%; object-fit: contain; margin-top: 6px; border-radius: 4px;">
                </article>
            <?php endif; ?>

            <article>
                <label for="id_imagen_archivo">Subir nueva imagen (reemplazará la actual):</label><br>
                <input type="file" id="id_imagen_archivo" name="imagen_archivo" accept="image/*" full>
            </article>

            <article>
                <label for="id_imagen">O cambiar enlace URL de imagen:</label><br>
                <input type="text" id="id_imagen" name="imagen" value="<?= htmlspecialchars($producto->_imagen ?? '') ?>" placeholder="https://..." full>
            </article>

            <article>
                <button type="submit" class="btn btn-info">
                    ✓ Guardar Cambios
                </button>
            </article>
        </form>
    </main>
</body>
</html>
