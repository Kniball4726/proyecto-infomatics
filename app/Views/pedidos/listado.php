<?php
/** @var array $pedidos */
/** @var bool $esAdmin */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = $esAdmin ? 'Gestión de Pedidos - InfoMatics' : 'Mis Pedidos - InfoMatics';
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
        .pedido-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.3rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .badge-completado {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        html[data-theme="dark"] .badge-completado {
            background: #1b381e !important;
            color: #81c784 !important;
        }
    </style>
</head>
<body>
    <div class="barra-superior">
        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="btn btn-secondary" onclick="location.href='/';">
                ← Volver a la tienda
            </button>
            <button type="button" class="btn btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
        </div>
        <button type="button" class="btn btn-secondary" onclick="location.href='/formulario-logout.php';">
            Cerrar sesión
        </button>
    </div>

    <main>
        <header style="margin-bottom: 1.5rem;">
            <h1 style="margin: 0; font-size: 2rem;">
                <?= $esAdmin ? '📦 Panel de Control de Pedidos' : '📋 Mis Pedidos Realizados' ?>
            </h1>
            <p style="color: #666; margin: 0.4rem 0 0;">
                <?= $esAdmin ? 'Listado general de todas las órdenes de clientes registradas:' : 'Historial de tus compras realizadas en InfoMatics:' ?>
            </p>
        </header>

        <?php if (empty($pedidos)): ?>
            <article style="text-align: center; padding: 3rem 1rem; background: #fafafa; border-radius: 12px; border: 1px dashed #ccc;">
                <p style="font-size: 1.25rem; color: #666; margin-bottom: 1.2rem;">
                    <?= $esAdmin ? 'No se ha registrado ninguna orden de compra aún.' : 'Aún no has realizado ninguna compra.' ?>
                </p>
                <button type="button" class="btn btn-primary btn-lg" onclick="location.href='/';">
                    Ir al catálogo de productos
                </button>
            </article>
        <?php else: ?>
            <section>
                <?php foreach ($pedidos as $pedido): ?>
                    <article class="pedido-card">
                        <div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.4rem;">
                                <h2 style="margin: 0; font-size: 1.3rem;">
                                    Pedido #<?= $pedido->_id ?>
                                </h2>
                                <span class="badge-completado">
                                    ✓ <?= htmlspecialchars($pedido->_estado ?? 'Completado') ?>
                                </span>
                            </div>

                            <p style="margin: 0.2rem 0; color: #666; font-size: 0.9rem;">
                                📅 <strong>Fecha:</strong> <?= htmlspecialchars($pedido->_fecha ?? '') ?>
                            </p>

                            <?php if ($esAdmin && !empty($pedido->cliente_nombre)): ?>
                                <p style="margin: 0.2rem 0; color: #444; font-size: 0.92rem;">
                                    👤 <strong>Cliente:</strong> <?= htmlspecialchars($pedido->cliente_nombre . ' ' . $pedido->cliente_apellido) ?> 
                                    <span style="color: #777;">(<?= htmlspecialchars($pedido->cliente_email) ?>)</span>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; align-items: center; gap: 18px; flex-wrap: wrap;">
                            <div style="text-align: right;">
                                <span style="font-size: 0.85rem; color: #777;">Monto Total:</span><br>
                                <strong style="font-size: 1.45rem; color: #d32f2f;">
                                    $ <?= number_format($pedido->_total, 2, ',', '.') ?>
                                </strong>
                            </div>

                            <button type="button" class="btn btn-info" onclick="location.href='/pedidos/ver/?id=<?= $pedido->_id ?>'">
                                📄 Ver Detalle
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
