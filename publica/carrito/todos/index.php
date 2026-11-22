<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/carrito.php';

requerirAuth();
requerirCliente();

$user = usuarioActual();
$todos = obtenerItemsCarrito($user->id);
$resumen = obtenerResumenCarrito($user->id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <title>InfoMatics - Carrito de Compras</title>
    <link rel="icon" href="/recursos/logo.png" type="image/png">
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red" />
    <style>
        .barra-superior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
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
        <button onclick="location.href='/';" style="background: transparent; border: 1px solid #777; color: #444; padding: 6px 14px; border-radius: 6px; cursor: pointer; font-weight: bold;">
            ← Seguir comprando
        </button>
        <button onclick="location.href='/formulario-logout.php';" style="background: transparent; border: 1px solid #bbb; color: #666; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
            Cerrar sesión
        </button>
    </div>

    <main>
        <header style="margin-bottom: 1.5rem;">
            <h1 style="margin: 0; font-size: 2rem;">🛒 Tu Carrito de Compras</h1>
        </header>

        <?php if (count($todos) === 0): ?>
            <article style="text-align: center; padding: 3rem 1rem; background: #fafafa; border-radius: 12px; border: 1px dashed #ccc;">
                <p style="font-size: 1.3rem; color: #666; margin-bottom: 1.5rem;">Tu carrito está actualmente vacío.</p>
                <button onclick="location.href='/';" style="background-color: #d32f2f; color: #ffffff !important; font-weight: bold; padding: 10px 22px; border-radius: 8px; border: none; cursor: pointer;">
                    Ver catálogo de productos
                </button>
            </article>
        <?php else: ?>
            <p style="color: #666; font-size: 1.05rem;">
                Tienes <strong><?= count($todos) ?></strong> producto(s) en tu lista (<strong><?= $resumen->total_items ?></strong> unidades en total):
            </p>

            <section>
                <?php foreach ($todos as $cadaRegistro): ?>
                    <?php include __DIR__ . "/render.php"; ?>
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
