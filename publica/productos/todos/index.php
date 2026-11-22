<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/productos.php';

$todos = obtenerProductos('DESC');
$admin = esAdmin();
$cliente = esCliente();
?>
<section>
    <p>En total hay <strong><?= count($todos) ?></strong> productos disponibles:</p>
    <?php if (count($todos) === 0): ?>
        <p>No hay ningún producto registrado.</p>
    <?php else: ?>
        <?php foreach ($todos as $cadaRegistro): ?>
            <?php include __DIR__ . "/render.php"; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
