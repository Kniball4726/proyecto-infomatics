<?php
/** @var object $pedido */
/** @var bool $esAdmin */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = "Detalle del Pedido #{$pedido->_id} - InfoMatics";
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
        .comprobante-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            margin-bottom: 2rem;
        }
        .comprobante-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px dashed #e0e0e0;
            padding-bottom: 1.2rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .tabla-items {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }
        .tabla-items th {
            text-align: left;
            background: #f8f9fa;
            padding: 10px 12px;
            font-size: 0.88rem;
            border-bottom: 2px solid #ddd;
        }
        html[data-theme="dark"] .tabla-items th {
            background: #252525 !important;
            border-bottom-color: #444 !important;
            color: #ffffff !important;
        }
        .tabla-items td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        html[data-theme="dark"] .tabla-items td {
            border-bottom-color: #333 !important;
        }
        .total-box {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 2px solid #e0e0e0;
        }
        @media print {
            .barra-superior, .btn-no-print {
                display: none !important;
            }
            .comprobante-card {
                box-shadow: none !important;
                border: 1px solid #000 !important;
            }
        }
    </style>
</head>
<body>
    <div class="barra-superior">
        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="btn btn-secondary" onclick="location.href='/pedidos/';">
                ← Volver a mis pedidos
            </button>
            <button type="button" class="btn btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="button" class="btn btn-secondary btn-no-print" onclick="window.print();">
                🖨️ Imprimir Comprobante
            </button>
            <button type="button" class="btn btn-primary" onclick="location.href='/';">
                Seguir comprando
            </button>
        </div>
    </div>

    <main>
        <article class="comprobante-card">
            <header class="comprobante-header">
                <div>
                    <h1 style="margin: 0; font-size: 1.8rem; color: #d32f2f;">
                        Comprobante de Pedido #<?= $pedido->_id ?>
                    </h1>
                    <p style="margin: 0.4rem 0 0; color: #666; font-size: 0.95rem;">
                        📅 <strong>Fecha:</strong> <?= htmlspecialchars($pedido->_fecha ?? '') ?> | 
                        <strong>Estado:</strong> <span style="color: #2e7d32; font-weight: bold;">✓ <?= htmlspecialchars($pedido->_estado ?? 'Completado') ?></span>
                    </p>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 700; font-size: 1.2rem;">InfoMatics Computación</div>
                    <span style="font-size: 0.85rem; color: #777;">Componentes & Tecnología</span>
                </div>
            </header>

            <!-- Datos del Cliente -->
            <section style="background: rgba(0,0,0,0.03); padding: 1rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.05rem;">Datos del Cliente</h3>
                <p style="margin: 0.2rem 0; font-size: 0.95rem;">
                    <strong>Nombre:</strong> <?= htmlspecialchars(($pedido->cliente_nombre ?? '') . ' ' . ($pedido->cliente_apellido ?? '')) ?>
                </p>
                <p style="margin: 0.2rem 0; font-size: 0.95rem;">
                    <strong>Email:</strong> <?= htmlspecialchars($pedido->cliente_email ?? '') ?>
                </p>
            </section>

            <!-- Tabla de Productos -->
            <table class="tabla-items">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align: center;">Categoría</th>
                        <th style="text-align: center;">Cantidad</th>
                        <th style="text-align: right;">Precio Unitario</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedido->items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($item->_nombre) ?></strong>
                            </td>
                            <td style="text-align: center;">
                                <span style="background: rgba(0,0,0,0.06); padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">
                                    <?= htmlspecialchars($item->_categoria ?? 'General') ?>
                                </span>
                            </td>
                            <td style="text-align: center; font-weight: bold;">
                                <?= (int)$item->_cantidad ?>
                            </td>
                            <td style="text-align: right;">
                                $ <?= number_format($item->_precioUnitario, 2, ',', '.') ?>
                            </td>
                            <td style="text-align: right; font-weight: bold; color: #d32f2f;">
                                $ <?= number_format($item->_subtotal, 2, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Resumen Total -->
            <div class="total-box">
                <div style="text-align: right;">
                    <span style="font-size: 0.9rem; color: #777; text-transform: uppercase; font-weight: bold;">Importe Total Abonado:</span>
                    <div style="font-size: 2.2rem; font-weight: 800; color: #d32f2f; margin-top: 0.2rem;">
                        $ <?= number_format($pedido->_total, 2, ',', '.') ?>
                    </div>
                </div>
            </div>
        </article>
    </main>
</body>
</html>
