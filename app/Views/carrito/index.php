<?php
/** @var array $items */
/** @var object $resumen */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = 'InfoMatics - Carrito de Compras';
    require __DIR__ . '/../layout/head.php'; 
    ?>
    <style>
        .barra-superior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            flex-wrap: wrap;
            gap: 10px;
        }
        .resumen-card {
            background: #ffffff;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-top: 2rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="barra-superior">
        <div style="display: flex; align-items: center; gap: 10px;">
            <button onclick="location.href='/';" style="background: transparent; border: 1px solid #777; color: #444; padding: 6px 14px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                ← Seguir comprando
            </button>
            <button type="button" class="btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
        </div>
        <button onclick="location.href='/formulario-logout.php';" style="background: transparent; border: 1px solid #bbb; color: #666; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
            Cerrar sesión
        </button>
    </div>

    <main>
        <header style="margin-bottom: 1.5rem;">
            <h1 style="margin: 0; font-size: 2rem;">🛒 Tu Carrito de Compras</h1>
        </header>

        <?php if (count($items) === 0): ?>
            <article style="text-align: center; padding: 3rem 1rem; background: #fafafa; border-radius: 12px; border: 1px dashed #ccc;">
                <p style="font-size: 1.3rem; color: #666; margin-bottom: 1.5rem;">Tu carrito está actualmente vacío.</p>
                <button onclick="location.href='/';" style="background-color: #d32f2f; color: #ffffff !important; font-weight: bold; padding: 10px 22px; border-radius: 8px; border: none; cursor: pointer;">
                    Ver catálogo de productos
                </button>
            </article>
        <?php else: ?>
            <p style="color: #666; font-size: 1.05rem;">
                Tienes <strong><?= count($items) ?></strong> producto(s) en tu lista (<strong><?= $resumen->total_items ?></strong> unidades en total):
            </p>

            <section>
                <?php foreach ($items as $cadaRegistro): ?>
                    <?php 
                    $idCarrito = $cadaRegistro->carrito_id ?? $cadaRegistro->_idCarrito ?? 0;
                    $idProd = $cadaRegistro->producto_id ?? $cadaRegistro->_idProducto ?? 0;
                    $nombre = $cadaRegistro->_nombre ?? '';
                    $precio = (float)($cadaRegistro->_precio ?? 0);
                    $cantidad = (int)($cadaRegistro->_cantidad ?? 1);
                    $subtotal = (float)($cadaRegistro->subtotal ?? ($precio * $cantidad));
                    ?>
                    <article id="idArticulo_<?= $idCarrito ?>" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="flex: 1; min-width: 200px;">
                            <h2 style="margin: 0 0 0.3rem 0; font-size: 1.3rem;"><?= htmlspecialchars($nombre) ?></h2>
                            <p style="margin: 0.3rem 0; font-weight: bold; color: #333;">
                                Precio unitario: $ <?= number_format($precio, 2, ',', '.') ?>
                            </p>
                        </div>

                        <!-- Ajuste de Cantidad y Subtotal -->
                        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                            <!-- Controles de Cantidad (+ y -) -->
                            <div style="display: flex; align-items: center; gap: 8px; background: #f0f0f0; padding: 4px 10px; border-radius: 8px; border: 1px solid #ccc;">
                                <button onclick="location.href='/carrito/quitar/?id=<?= $idProd ?>'" title="Restar 1 unidad" style="background: #e0e0e0; color: #111; border: 1px solid #bbb; font-size: 1.1rem; width: 32px; height: 32px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    -
                                </button>
                                <span style="font-weight: 800; font-size: 1.15rem; min-width: 30px; text-align: center; color: #111;">
                                    <?= $cantidad ?>
                                </span>
                                <button onclick="location.href='/carrito/agregar/?id=<?= $idProd ?>'" title="Sumar 1 unidad" style="background: #e0e0e0; color: #111; border: 1px solid #bbb; font-size: 1.1rem; width: 32px; height: 32px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    +
                                </button>
                            </div>

                            <!-- Subtotal -->
                            <div style="text-align: right; min-width: 140px;">
                                <span style="font-size: 0.85rem; color: #777;">Subtotal:</span><br>
                                <strong style="font-size: 1.3rem; color: #d32f2f;">
                                    $ <?= number_format($subtotal, 2, ',', '.') ?>
                                </strong>
                            </div>

                            <!-- Botón Quitar por completo -->
                            <div>
                                <button onclick="if(confirm('¿Seguro que deseas quitar <?= addslashes($nombre) ?> del carrito?')) location.href='/carrito/quitar/?id=<?= $idProd ?>&todo=1'" style="background-color: #b71c1c; color: #ffffff !important; border: 1px solid #7f0000; font-weight: bold; border-radius: 6px; padding: 8px 14px; cursor: pointer;">
                                    🗑️ Quitar
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>

            <!-- Resumen Total y Ajuste de Monto -->
            <article class="resumen-card">
                <div>
                    <span style="font-size: 0.95rem; color: #777; text-transform: uppercase; font-weight: bold;">Total del pedido:</span>
                    <div style="font-size: 2.2rem; font-weight: 800; color: #d32f2f; margin-top: 0.2rem;">
                        $ <?= number_format($resumen->total_precio, 2, ',', '.') ?>
                    </div>
                    <span style="color: #555; font-size: 0.9rem;">(Total acumulado de <?= $resumen->total_items ?> unidades)</span>
                </div>

                <div>
                    <button onclick="alert('¡Compra realizada con éxito! Monto: $ <?= number_format($resumen->total_precio, 2, ',', '.') ?>'); location.href='/';" style="background-color: #2e7d32; color: #ffffff !important; font-weight: bold; padding: 12px 28px; font-size: 1.1rem; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(46,125,50,0.3);">
                        Finalizar Compra
                    </button>
                </div>
            </article>
        <?php endif; ?>
    </main>
</body>
</html>
