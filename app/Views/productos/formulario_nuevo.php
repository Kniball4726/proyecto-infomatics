<?php
/** @var string|null $error */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = 'Nuevo Producto - InfoMatics';
    require __DIR__ . '/../layout/head.php'; 
    ?>
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
        <h1 style="margin: 0;">Insertar nuevo producto</h1>
        <nav style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='/'">← Volver al catálogo</button>
        </nav>
    </header>
    <main>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/productos/nuevo/procesar.php" method="POST" enctype="multipart/form-data">
            <?= \App\Services\CsrfService::campoHtml() ?>
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
                <input type="text" id="id_categoria" name="categoria" placeholder="Ej: Periféricos, Componentes, Audio" required full>
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
                <label for="id_imagen_archivo">Subir Imagen desde tu equipo (recomendado):</label><br>
                <input type="file" id="id_imagen_archivo" name="imagen_archivo" accept="image/*" full>
                <small style="color: #666; display: block; margin-top: 4px;">Formatos soportados: JPG, PNG, WEBP, GIF.</small>
            </article>

            <article>
                <label for="id_imagen">O pegar URL de imagen externa:</label><br>
                <input type="url" id="id_imagen" name="imagen" placeholder="https://ejemplo.com/foto.jpg" full>
            </article>

            <article>
                <button type="submit" class="btn btn-success">
                    ✓ Guardar Producto
                </button>
            </article>
        </form>
    </main>
</body>
</html>
