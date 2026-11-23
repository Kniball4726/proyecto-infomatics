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
        <button type="button" class="btn btn-toggle-theme" onclick="toggleTheme()" title="Cambiar tema">
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
                <button type="button" class="btn btn-success" onclick="location.href='/productos/nuevo/';">
                    ➕ Nuevo Producto
                </button>
                <button type="button" class="btn btn-info" onclick="location.href='/usuarios/todos/';">
                    👥 Clientes
                </button>
                <button type="button" class="btn btn-secondary" onclick="location.href='/pedidos/';" style="border-color: #666; color: #e0e0e0 !important;">
                    📦 Pedidos
                </button>
            <?php else: 
                $userId = (int)($user->_id ?? $user->id ?? 0);
                $resumen = CarritoService::obtenerResumen($userId);
            ?>
                <button type="button" class="btn btn-primary" onclick="location.href='/carrito/todos';" style="gap: 10px;">
                    <span>🛒 Carrito: <strong><?= $resumen->total_items ?></strong> <?= ($resumen->total_items == 1 ? 'ítem' : 'ítems') ?></span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 0.88rem;">$ <?= number_format($resumen->total_precio, 2, ',', '.') ?></span>
                </button>
                <button type="button" class="btn btn-secondary" onclick="location.href='/pedidos/';" style="border-color: #666; color: #e0e0e0 !important;">
                    📋 Mis Pedidos
                </button>
            <?php endif; ?>

            <button type="button" class="btn btn-secondary" onclick="location.href='/formulario-logout.php'" style="border-color: #666; color: #e0e0e0 !important;">
                Cerrar sesión
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-primary" onclick="location.href='/formulario-login.php'">
                🔑 Iniciar sesión
            </button>
        <?php endif; ?>
    </div>
</nav>
