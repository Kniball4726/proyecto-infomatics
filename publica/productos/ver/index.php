<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/productos.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$encontrado = obtenerProductoPorId($id);
$admin = esAdmin();
$cliente = esCliente();
$autenticado = estaAutenticado();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <title><?= $encontrado ? htmlspecialchars($encontrado->_nombre) . ' - InfoMatics' : 'Producto no encontrado' ?></title>
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
        .btn-volver {
            background: transparent;
            border: 1px solid #777;
            color: #444;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
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
        .btn-comprar {
            background-color: #d32f2f;
            color: #ffffff !important;
            font-size: 1.05rem;
            font-weight: bold;
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(211,47,47,0.3);
        }
        .btn-modificar {
            background-color: #0277bd;
            color: #ffffff !important;
            font-weight: bold;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
        .btn-eliminar {
            background-color: #b71c1c;
            color: #ffffff !important;
            font-weight: bold;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="barra-superior">
        <button class="btn-volver" onclick="location.href='/'">← Volver al catálogo</button>
        <?php if ($admin): ?>
            <span style="font-size: 0.85rem; color: #2e7d32; font-weight: bold; background: #e8f5e9; padding: 4px 10px; border-radius: 12px;">Modo Administrador</span>
        <?php elseif ($autenticado): ?>
            <span style="font-size: 0.85rem; color: #0277bd; font-weight: bold; background: #e1f5fe; padding: 4px 10px; border-radius: 12px;">Modo Cliente</span>
        <?php endif; ?>
    </div>

    <main>
    <?php if (!$encontrado): ?>
        <p>No se encontró el producto solicitado.</p>
    <?php else: ?>
        <article class="ficha-producto">
            <!-- Columna 1: Imagen -->
            <div class="imagen-contenedor">
                <?php if (!empty($encontrado->_imagen)): ?>
                    <img src="<?= htmlspecialchars($encontrado->_imagen) ?>" alt="<?= htmlspecialchars($encontrado->_nombre) ?>">
                <?php else: ?>
                    <img src="/recursos/logo.png" alt="InfoMatics" style="opacity: 0.4; max-width: 160px;">
                <?php endif; ?>
            </div>

            <!-- Columna 2: Detalles y Acciones -->
            <div>
                <span class="categoria-badge"><?= htmlspecialchars($encontrado->_categoria) ?></span>
                <h1 style="margin: 0.3rem 0; font-size: 1.8rem; line-height: 1.2;"><?= htmlspecialchars($encontrado->_nombre) ?></h1>
                
                <div class="precio-tag">
                    $ <?= number_format($encontrado->_precio, 2, ',', '.') ?>
                </div>

                <div class="stock-tag">
                    ✓ Stock disponible: <?= $encontrado->_stock ?> unidades
                </div>

                <div style="color: #555; line-height: 1.6; margin-bottom: 1.5rem;">
                    <strong>Descripción:</strong>
                    <p style="margin-top: 0.4rem;"><?= nl2br(htmlspecialchars($encontrado->_descripcion ?? 'Sin descripción')) ?></p>
                </div>

                <div class="panel-acciones">
                    <?php if ($cliente): ?>
                        <button class="btn-comprar" onclick="location.href='/carrito/agregar/?id=<?= $id ?>'">
                            🛒 Agregar al carrito
                        </button>
                    <?php endif; ?>

                    <?php if ($admin): ?>
                        <button class="btn-modificar" onclick="location.href='/productos/editar/?id=<?= $id ?>'">
                            ✏️ Modifica
                        </button>
                        <button class="btn-eliminar" onclick="if(confirm('¿Seguro que deseas eliminar <?= addslashes($encontrado->_nombre) ?>?')) location.href='/productos/borrar/procesar.php?id=<?= $id ?>'">
                            🗑️ Eliminar
                        </button>
                    <?php endif; ?>

                    <?php if (!$autenticado): ?>
                        <button class="btn-comprar" onclick="location.href='/formulario-login.php'">
                            Inicia sesión para comprar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php endif; ?>
    </main>
</body>
</html>
