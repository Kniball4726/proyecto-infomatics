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
        <button onclick="location.href='/productos/ver?id=<?= $cadaRegistro->_id ?>'">Más info</button>
        
        <?php if ($cliente): ?>
            <button onclick="location.href='/carrito/agregar/?id=<?= $cadaRegistro->_id ?>'" style="background-color: #d32f2f; color: #ffffff !important; border: 1px solid #b71c1c; font-weight: bold; cursor: pointer;">
                🛒 Agregar al carrito
            </button>
        <?php endif; ?>

        <?php if ($admin): ?>
            <button onclick="location.href='/productos/editar/?id=<?= $cadaRegistro->_id ?>'" style="background-color: #0277bd; color: #ffffff !important; border: 1px solid #01579b; font-weight: bold; cursor: pointer;">
                ✏️ Modifica
            </button>
            <button onclick="if(confirm('¿Seguro que deseas eliminar <?= addslashes($cadaRegistro->_nombre) ?>?')) location.href='/productos/borrar/procesar.php?id=<?= $cadaRegistro->_id ?>'" style="background-color: #b71c1c; color: #ffffff !important; border: 1px solid #7f0000; font-weight: bold; cursor: pointer;">
                🗑️ Eliminar
            </button>
        <?php endif; ?>
    </nav>
</article>
