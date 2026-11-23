<?php
use App\Services\AuthService;
use App\Services\CarritoService;

$user = AuthService::usuarioActual();
$admin = AuthService::esAdmin();
?>
<nav class="navbar-pro">
    <div class="brand-pro" onclick="location.href='/'">
        <img src="/recursos/logo.png" alt="InfoMatics">
        <span>InfoMatics</span>
    </div>
    
    <div class="nav-actions-pro">
        <!-- Botón Dark Mode -->
        <button type="button" class="btn-toggle-theme" onclick="toggleTheme()" title="Cambiar tema">
            🌙 Modo Oscuro
        </button>

        <?php if ($user): ?>
            <!-- Badge de Usuario -->
            <span class="user-badge-pro">
                👤 <?= htmlspecialchars($user->_nombre ?? $user->nombre ?? '') ?>
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
                <button onclick="location.href='/usuarios/todos/';" style="background-color: #0277bd; color: #ffffff !important; border: 1px solid #01579b; font-weight: bold; border-radius: 6px; padding: 7px 14px; cursor: pointer;">
                    👥 Clientes
                </button>
            <?php else: 
                $userId = (int)($user->_id ?? $user->id ?? 0);
                $resumen = CarritoService::obtenerResumen($userId);
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
