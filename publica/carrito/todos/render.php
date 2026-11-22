<article id="idArticulo_<?= $cadaRegistro->_idCarrito ?>" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div style="flex: 1; min-width: 200px;">
        <h2 style="margin: 0 0 0.3rem 0; font-size: 1.3rem;"><?= htmlspecialchars($cadaRegistro->_nombre) ?></h2>
        <p style="margin: 0.2rem 0; color: #666; font-size: 0.95rem;"><?= htmlspecialchars($cadaRegistro->_descripcion ?? '') ?></p>
        <p style="margin: 0.3rem 0; font-weight: bold; color: #333;">
            Precio unitario: $ <?= number_format($cadaRegistro->_precio, 2, ',', '.') ?>
        </p>
    </div>

    <!-- Ajuste de Cantidad y Subtotal -->
    <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
        <!-- Controles de Cantidad (+ y -) -->
        <div style="display: flex; align-items: center; gap: 8px; background: #f0f0f0; padding: 4px 10px; border-radius: 8px; border: 1px solid #ccc;">
            <button onclick="location.href='/carrito/quitar/?id=<?= $cadaRegistro->_idProducto ?>'" title="Restar 1 unidad" style="background: #e0e0e0; color: #111; border: 1px solid #bbb; font-size: 1.1rem; width: 32px; height: 32px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                -
            </button>
            <span style="font-weight: 800; font-size: 1.15rem; min-width: 30px; text-align: center; color: #111;">
                <?= $cadaRegistro->_cantidad ?>
            </span>
            <button onclick="location.href='/carrito/agregar/?id=<?= $cadaRegistro->_idProducto ?>'" title="Sumar 1 unidad" style="background: #e0e0e0; color: #111; border: 1px solid #bbb; font-size: 1.1rem; width: 32px; height: 32px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                +
            </button>
        </div>

        <!-- Subtotal -->
        <div style="text-align: right; min-width: 140px;">
            <span style="font-size: 0.85rem; color: #777;">Subtotal:</span><br>
            <strong style="font-size: 1.3rem; color: #d32f2f;">
                $ <?= number_format($cadaRegistro->_precio * $cadaRegistro->_cantidad, 2, ',', '.') ?>
            </strong>
        </div>

        <!-- Botón Quitar por completo -->
        <div>
            <button onclick="if(confirm('¿Seguro que deseas quitar <?= addslashes($cadaRegistro->_nombre) ?> del carrito?')) location.href='/carrito/quitar/?id=<?= $cadaRegistro->_idProducto ?>&todo=1'" style="background-color: #b71c1c; color: #ffffff !important; border: 1px solid #7f0000; font-weight: bold; border-radius: 6px; padding: 8px 14px; cursor: pointer;">
                🗑️ Quitar
            </button>
        </div>
    </div>
</article>
