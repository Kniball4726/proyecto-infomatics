<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/layout.php';
requerirAdmin();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Nuevo Producto - InfoMatics'); ?>
    <style>[full]{ width: 100% }</style>
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
        <h1 style="margin: 0;">Insertar nuevo producto</h1>
        <nav style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
            <button onclick="location.href='/'">← Volver al catálogo</button>
        </nav>
    </header>
    <main>
        <?php if (!empty($_SESSION["error"])): ?>
            <p style="color: red;"><?= htmlspecialchars($_SESSION["error"]) ?></p>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

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
