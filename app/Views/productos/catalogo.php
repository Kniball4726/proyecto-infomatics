<?php
/** @var array $productos */
use App\Services\AuthService;
$admin = AuthService::esAdmin();
$cliente = AuthService::esCliente();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require __DIR__ . '/../layout/head.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/../layout/header_completo.php'; ?>
    <main>
        <section style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="margin: 0; font-size: 1.6rem;">Catálogo de Productos Disponibles</h2>
            <span style="color: #666; font-size: 0.95rem;">Total: <?= count($productos) ?> productos</span>
        </section>

        <?php if (empty($productos)): ?>
            <p>No hay productos disponibles en este momento.</p>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.2rem;">
                <?php foreach ($productos as $cadaRegistro): ?>
                    <article id="idArticulo_<?= $cadaRegistro->_id ?>" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.2rem; box-shadow: 0 2px 6px rgba(0,0,0,0.04); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <?php if (!empty($cadaRegistro->_imagen)): ?>
                                <div style="text-align: center; margin-bottom: 0.8rem; background: #fafafa; border-radius: 6px; padding: 0.8rem; min-height: 140px; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?= htmlspecialchars($cadaRegistro->_imagen) ?>" alt="<?= htmlspecialchars($cadaRegistro->_nombre) ?>" style="max-height: 120px; max-width: 100%; object-fit: contain;">
                                </div>
                            <?php endif; ?>
                            <h2 style="margin: 0 0 0.4rem; font-size: 1.25rem;"><?= htmlspecialchars($cadaRegistro->_nombre) ?></h2>
                            <p style="margin: 0.3rem 0; font-size: 1.2rem; font-weight: bold; color: #d32f2f;">
                                $ <?= number_format($cadaRegistro->_precio, 2, ',', '.') ?>
                            </p>
                        </div>
                        <nav style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-top: 10px;">
                            <button onclick="location.href='/productos/ver?id=<?= $cadaRegistro->_id ?>'">Más info</button>
                            
                            <?php if ($cliente): ?>
                                <button onclick="location.href='/carrito/agregar/?id=<?= $cadaRegistro->_id ?>'" style="background-color: #d32f2f; color: #ffffff !important; border: 1px solid #b71c1c; font-weight: bold; cursor: pointer;">
                                    🛒 Agregar al carrito
                                </button>
                            <?php endif; ?>

                            <?php if ($admin): ?>
                                <button onclick="location.href='/productos/editar/?id=<?= $cadaRegistro->_id ?>'" style="background-color: #0277bd; color: #ffffff !important; border: 1px solid #01579b; font-weight: bold; cursor: pointer;">
                                    ✏️ Modifica
                                </button>
                                <button onclick="if(confirm('¿Seguro que deseas eliminar <?= addslashes($cadaRegistro->_nombre) ?>?')) location.href='/productos/borrar/procesar.php?id=<?= $cadaRegistro->_id ?>'" style="background-color: #b71c1c; color: #ffffff !important; border: 1px solid #7f0000; font-weight: bold; cursor: pointer;">
                                    🗑️ Eliminar
                                </button>
                            <?php endif; ?>
                        </nav>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
