<?php
/** @var object|null $producto */
use App\Services\AuthService;
$admin = AuthService::esAdmin();
$cliente = AuthService::esCliente();
$autenticado = AuthService::estaAutenticado();
$encontrado = $producto;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = $encontrado ? htmlspecialchars($encontrado->_nombre) . ' - InfoMatics' : 'Producto no encontrado';
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
        .ficha-producto {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        @media (min-width: 700px) {
            .ficha-producto {
                grid-template-columns: 320px 1fr;
            }
        }
        .imagen-contenedor {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            min-height: 250px;
            border: 1px solid #eee;
        }
        .imagen-contenedor img {
            max-width: 100%;
            max-height: 280px;
            object-fit: contain;
        }
        .categoria-badge {
            display: inline-block;
            background: #eee;
            color: #555;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .precio-tag {
            font-size: 2rem;
            font-weight: 800;
            color: #d32f2f;
            margin: 1rem 0;
        }
        .stock-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.95rem;
            color: #2e7d32;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .panel-acciones {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f0f0f0;
        }
    </style>
</head>
<body>
    <header class="barra-superior">
        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="btn btn-secondary" onclick="location.href='/'">← Volver al catálogo</button>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
            <?php if ($cliente): ?>
                <button type="button" class="btn btn-primary" onclick="location.href='/carrito/todos'">
                    🛒 Ver Carrito
                </button>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <?php if (!$encontrado): ?>
            <article style="text-align: center; padding: 3rem 1rem;">
                <h2>⚠️ Producto no encontrado</h2>
                <p>El producto solicitado no existe o fue dado de baja.</p>
                <button type="button" class="btn btn-secondary" onclick="location.href='/'">Volver a la tienda</button>
            </article>
        <?php else: ?>
            <article class="ficha-producto">
                <div class="imagen-contenedor">
                    <img src="<?= htmlspecialchars($encontrado->_imagen ?? '/recursos/logo.png') ?>" alt="<?= htmlspecialchars($encontrado->_nombre) ?>">
                </div>

                <div class="info-contenedor">
                    <?php if (!empty($encontrado->_categoria)): ?>
                        <span class="categoria-badge"><?= htmlspecialchars($encontrado->_categoria) ?></span>
                    <?php endif; ?>

                    <h1 style="margin: 0.2rem 0 0.8rem; font-size: 2rem;"><?= htmlspecialchars($encontrado->_nombre) ?></h1>

                    <div class="precio-tag">
                        $ <?= number_format($encontrado->_precio, 2, ',', '.') ?>
                    </div>

                    <div class="stock-tag">
                        <?php $stockActual = (int)($encontrado->_stock ?? 0); ?>
                        <?php if ($stockActual <= 0): ?>
                            <span>❌</span>
                            <span style="color: #c62828;">Estado: <strong>Agotado (Sin stock disponible)</strong></span>
                        <?php elseif ($stockActual <= 3): ?>
                            <span>⚡</span>
                            <span style="color: #e65100;">¡Apresúrate! Solo quedan <strong><?= $stockActual ?> unidades en stock</strong></span>
                        <?php else: ?>
                            <span>📦</span>
                            <span>Stock disponible: <strong><?= $stockActual ?> unidades</strong></span>
                        <?php endif; ?>
                    </div>

                    <p style="font-size: 1.05rem; line-height: 1.6; color: #444; margin: 0 0 1.5rem;">
                        <?= nl2br(htmlspecialchars($encontrado->_descripcion)) ?>
                    </p>

                    <!-- Panel de acciones contextuales dentro de la tarjeta -->
                    <div class="panel-acciones">
                        <?php if ($cliente): ?>
                            <?php if ($stockActual > 0): ?>
                                <button type="button" class="btn btn-primary btn-lg" onclick="location.href='/carrito/agregar/?id=<?= $encontrado->_id ?>'">
                                    <span>🛒 Agregar al carrito</span>
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary btn-lg" disabled style="opacity: 0.5; cursor: not-allowed;" title="Producto sin stock disponible">
                                    <span>Agotado</span>
                                </button>
                            <?php endif; ?>
                        <?php elseif (!$autenticado): ?>
                            <button type="button" class="btn btn-primary btn-lg" onclick="location.href='/formulario-login.php'">
                                Inicia sesión para comprar
                            </button>
                        <?php endif; ?>

                        <?php if ($admin): ?>
                            <button type="button" class="btn btn-info" onclick="location.href='/productos/editar/?id=<?= $encontrado->_id ?>'">
                                ✏️ Modificar Producto
                            </button>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('¿Seguro que deseas eliminar este producto?')) location.href='/productos/borrar/procesar.php?id=<?= $encontrado->_id ?>'">
                                🗑️ Eliminar Producto
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endif; ?>
    </main>
</body>
</html>
