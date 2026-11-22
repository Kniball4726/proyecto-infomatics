<?php
/**
 * Componentes de Presentación y Layout Reutilizables
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/carrito.php';

function renderHead(string $titulo = 'InfoMatics Computación'): void {
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="icon" href="/recursos/logo.png" type="image/png">
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
    <style>
        header.cabecera-pro {
            padding: 0;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.1);
        }
        .navbar-pro {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 1.5rem;
            background: #1e1e1e;
            color: #ffffff;
            flex-wrap: wrap;
            gap: 12px;
        }
        .brand-pro {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
            cursor: pointer;
        }
        .brand-pro img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }
        .brand-pro span {
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-actions-pro {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .user-badge-pro {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            background: #2a2a2a;
            color: #e0e0e0;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #444;
        }
        .hero-pro {
            position: relative;
            background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.7)), url('/recursos/portada.png') center/cover no-repeat;
            padding: 3.5rem 2rem;
            color: #ffffff;
            text-align: center;
        }
        .hero-pro h1 {
            margin: 0;
            font-size: 2.3rem;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.8);
        }
        .hero-pro p {
            margin: 0.6rem 0 0;
            font-size: 1.15rem;
            color: #f0f0f0;
            text-shadow: 0 1px 5px rgba(0,0,0,0.7);
        }
        .btn-comprar-card {
            background-color: #d32f2f;
            color: #ffffff !important;
            border: 1px solid #b71c1c;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-modificar-card {
            background-color: #0277bd;
            color: #ffffff !important;
            border: 1px solid #01579b;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-eliminar-card {
            background-color: #b71c1c;
            color: #ffffff !important;
            border: 1px solid #7f0000;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
<?php
}

function renderNavbar(): void {
    $user = usuarioActual();
    $admin = esAdmin();
?>
    <nav class="navbar-pro">
        <div class="brand-pro" onclick="location.href='/'">
            <img src="/recursos/logo.png" alt="InfoMatics">
            <span>InfoMatics</span>
        </div>
        
        <div class="nav-actions-pro">
            <?php if ($user): ?>
                <!-- Badge de Usuario -->
                <span class="user-badge-pro">
                    👤 <?= htmlspecialchars($user->nombre) ?>
                    <?php if ($admin): ?>
                        <strong style="color: #4caf50; font-size: 0.8rem; margin-left: 2px;">[ADMIN]</strong>
                    <?php else: ?>
                        <strong style="color: #64b5f6; font-size: 0.8rem; margin-left: 2px;">[CLIENTE]</strong>
                    <?php endif; ?>
                </span>

                <?php if ($admin): ?>
                    <button onclick="location.href='/productos/nuevo/';" style="background-color: #2e7d32; color: #ffffff !important; border: 1px solid #1b5e20; font-weight: bold; border-radius: 6px; padding: 7px 14px; cursor: pointer;">
                        ➕ Nuevo Producto
                    </button>
                <?php else: 
                    $resumen = obtenerResumenCarrito($user->id);
                ?>
                    <button onclick="location.href='/carrito/todos';" style="background-color: #d32f2f; color: #ffffff !important; border: 1px solid #b71c1c; font-weight: bold; border-radius: 6px; padding: 7px 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <span>🛒 Carrito: <strong><?= $resumen->total_items ?></strong> <?= ($resumen->total_items == 1 ? 'ítem' : 'ítems') ?></span>
                        <span style="background: rgba(0,0,0,0.25); padding: 2px 8px; border-radius: 4px; font-weight: 800;">$ <?= number_format($resumen->total_precio, 2, ',', '.') ?></span>
                    </button>
                <?php endif; ?>

                <button onclick="location.href='/formulario-logout.php'" style="background: transparent; border: 1px solid #777; color: #e0e0e0; font-weight: bold; border-radius: 6px; padding: 7px 12px; cursor: pointer;">
                    Cerrar sesión
                </button>
            <?php else: ?>
                <button onclick="location.href='/formulario-login.php'" style="background-color: #d32f2f; color: #ffffff !important; border: 1px solid #b71c1c; font-weight: bold; border-radius: 6px; padding: 7px 16px; cursor: pointer;">
                    🔑 Iniciar sesión
                </button>
            <?php endif; ?>
        </div>
    </nav>
<?php
}

function renderHero(string $titulo = 'Componentes & Tecnología de Alto Rendimiento', string $subtitulo = 'Explora nuestro catálogo con los mejores precios y stock actualizado'): void {
?>
    <div class="hero-pro">
        <h1><?= htmlspecialchars($titulo) ?></h1>
        <p><?= htmlspecialchars($subtitulo) ?></p>
    </div>
<?php
}

function renderHeaderCompleto(string $tituloHero = 'Componentes & Tecnología de Alto Rendimiento', string $subtituloHero = 'Explora nuestro catálogo con los mejores precios y stock actualizado'): void {
?>
    <header class="cabecera-pro">
        <?php renderNavbar(); ?>
        <?php renderHero($tituloHero, $subtituloHero); ?>
    </header>
<?php
}
