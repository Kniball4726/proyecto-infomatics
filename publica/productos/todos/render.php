<?php
require_once __DIR__ . '/../../../includes/auth.php';
$admin = esAdmin();
$cliente = esCliente();
?>
<article id="idArticulo_<?= $cadaRegistro->_id ?>" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
    <h2 style="margin: 0 0 0.4rem; font-size: 1.35rem;"><?= htmlspecialchars($cadaRegistro->_nombre) ?></h2>
    <p style="margin: 0.3rem 0; font-size: 1.1rem; font-weight: bold; color: #d32f2f;">
        Precio: $ <?= number_format($cadaRegistro->_precio, 2, ',', '.') ?>
    </p>
    <nav style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-top: 10px;">
        <button type="button" class="btn btn-secondary" onclick="location.href='/productos/ver/?id=<?= $cadaRegistro->_id ?>'">
            ℹ️ Más info
        </button>
        
        <?php if ($cliente): ?>
            <button type="button" class="btn btn-primary" onclick="location.href='/carrito/agregar/?id=<?= $cadaRegistro->_id ?>'">
                🛒 Agregar al carrito
            </button>
        <?php endif; ?>

        <?php if ($admin): ?>
            <button type="button" class="btn btn-info" onclick="location.href='/productos/editar/?id=<?= $cadaRegistro->_id ?>'">
                ✏️ Modificar
            </button>
            <button type="button" class="btn btn-danger" onclick="if(confirm('¿Seguro que deseas eliminar <?= addslashes($cadaRegistro->_nombre) ?>?')) location.href='/productos/borrar/procesar.php?id=<?= $cadaRegistro->_id ?>'">
                🗑️ Eliminar
            </button>
        <?php endif; ?>
    </nav>
</article>
