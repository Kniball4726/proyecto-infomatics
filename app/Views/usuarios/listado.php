<?php
/** @var array $usuarios */
/** @var string|null $mensaje */
/** @var string|null $error */
use App\Services\AuthService;
$currentUser = AuthService::usuarioActual();
$currentUserId = (int)($currentUser->_id ?? $currentUser->id ?? 0);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = 'Gestión de Clientes y Usuarios - InfoMatics';
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
        <button type="button" class="btn btn-success" onclick="location.href='/usuarios/nuevo/';">
            ➕ Registrar Nuevo Cliente
        </button>
    </div>

    <main>
        <header style="margin-bottom: 1.5rem;">
            <h1 style="margin: 0; font-size: 2rem;">👥 Panel de Gestión de Clientes</h1>
        </header>

        <?php if (!empty($mensaje)): ?>
            <p style="background: #e8f5e9; color: #2e7d32; padding: 10px 14px; border-radius: 6px; font-weight: bold;">
                <?= htmlspecialchars($mensaje) ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p style="background: #ffebee; color: #b71c1c; padding: 10px 14px; border-radius: 6px; font-weight: bold;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <p style="color: #666;">En total hay <strong><?= count($usuarios) ?></strong> cuentas registradas en el sistema:</p>

        <section>
            <?php foreach ($usuarios as $cadaRegistro): ?>
                <?php 
                $userId = (int)($cadaRegistro->_id ?? $cadaRegistro->id ?? 0);
                $esEsteUsuario = ($userId === $currentUserId);
                $esRolAdmin = ((int)($cadaRegistro->_nivel ?? 0) > 1);
                $nombreCompleto = trim(($cadaRegistro->_nombre ?? '') . ' ' . ($cadaRegistro->_apellido ?? ''));
                ?>
                <article id="idArticulo_<?= $userId ?>" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div style="flex: 1; min-width: 220px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.3rem;">
                            <h2 style="margin: 0; font-size: 1.3rem;">
                                <?= htmlspecialchars($nombreCompleto) ?>
                            </h2>
                            <?php if ($esRolAdmin): ?>
                                <span style="background: #e8f5e9; color: #2e7d32; font-size: 0.75rem; font-weight: bold; padding: 2px 8px; border-radius: 10px;">ADMIN</span>
                            <?php else: ?>
                                <span style="background: #e1f5fe; color: #0277bd; font-size: 0.75rem; font-weight: bold; padding: 2px 8px; border-radius: 10px;">CLIENTE</span>
                            <?php endif; ?>
                        </div>
                        <p style="margin: 0.2rem 0; color: #555;"><strong>Email:</strong> <?= htmlspecialchars($cadaRegistro->_email ?? '') ?></p>
                        <p style="margin: 0.2rem 0; color: #888; font-size: 0.85rem;">Registrado: <?= htmlspecialchars($cadaRegistro->_fechaRegistro ?? 'N/A') ?></p>
                    </div>

                    <nav style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <button type="button" class="btn btn-info" onclick="location.href='/usuarios/editar/?id=<?= $userId ?>'">
                            ✏️ Modificar
                        </button>

                        <?php if (!$esEsteUsuario): ?>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('¿Seguro que deseas eliminar al cliente <?= addslashes($nombreCompleto) ?>?')) location.href='/usuarios/borrar/procesar.php?id=<?= $userId ?>'">
                                🗑️ Eliminar
                            </button>
                        <?php else: ?>
                            <span style="font-size: 0.85rem; color: #888; padding: 6px 10px;">(Tu cuenta)</span>
                        <?php endif; ?>
                    </nav>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
