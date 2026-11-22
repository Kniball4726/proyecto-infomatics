<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/usuarios.php';

requerirAdmin();

$todos = obtenerUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <title>Gestión de Clientes y Usuarios - InfoMatics</title>
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
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="barra-superior">
        <button onclick="location.href='/';" style="background: transparent; border: 1px solid #777; color: #444; padding: 6px 14px; border-radius: 6px; cursor: pointer; font-weight: bold;">
            ← Volver a la tienda
        </button>
        <button onclick="location.href='/usuarios/nuevo/';" style="background-color: #2e7d32; color: #ffffff !important; border: 1px solid #1b5e20; font-weight: bold; border-radius: 6px; padding: 7px 16px; cursor: pointer;">
            ➕ Registrar Nuevo Cliente
        </button>
    </div>

    <main>
        <header style="margin-bottom: 1.5rem;">
            <h1 style="margin: 0; font-size: 2rem;">👥 Panel de Gestión de Clientes</h1>
        </header>

        <?php if (!empty($_SESSION["mensaje"])): ?>
            <p style="background: #e8f5e9; color: #2e7d32; padding: 10px 14px; border-radius: 6px; font-weight: bold;">
                <?= htmlspecialchars($_SESSION["mensaje"]) ?>
            </p>
            <?php unset($_SESSION["mensaje"]); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION["error"])): ?>
            <p style="background: #ffebee; color: #b71c1c; padding: 10px 14px; border-radius: 6px; font-weight: bold;">
                <?= htmlspecialchars($_SESSION["error"]) ?>
            </p>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <p style="color: #666;">En total hay <strong><?= count($todos) ?></strong> cuentas registradas en el sistema:</p>

        <section>
            <?php foreach ($todos as $cadaRegistro): ?>
                <?php include __DIR__ . "/render.php"; ?>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
