<?php
$currentUser = usuarioActual();
$esEsteUsuario = ($currentUser && $currentUser->id == $cadaRegistro->_id);
$esRolAdmin = ($cadaRegistro->_nivel > 1);
?>
<article id="idArticulo_<?= $cadaRegistro->_id ?>" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div style="flex: 1; min-width: 220px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.3rem;">
            <h2 style="margin: 0; font-size: 1.3rem;">
                <?= htmlspecialchars($cadaRegistro->_nombre . ' ' . $cadaRegistro->_apellido) ?>
            </h2>
            <?php if ($esRolAdmin): ?>
                <span style="background: #e8f5e9; color: #2e7d32; font-size: 0.75rem; font-weight: bold; padding: 2px 8px; border-radius: 10px;">ADMIN</span>
            <?php else: ?>
                <span style="background: #e1f5fe; color: #0277bd; font-size: 0.75rem; font-weight: bold; padding: 2px 8px; border-radius: 10px;">CLIENTE</span>
            <?php endif; ?>
        </div>
        <p style="margin: 0.2rem 0; color: #555;"><strong>Email:</strong> <?= htmlspecialchars($cadaRegistro->_email) ?></p>
        <p style="margin: 0.2rem 0; color: #888; font-size: 0.85rem;">Registrado: <?= htmlspecialchars($cadaRegistro->_fechaRegistro ?? 'N/A') ?></p>
    </div>

    <nav style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
        <button type="button" class="btn btn-info" onclick="location.href='/usuarios/editar/?id=<?= $cadaRegistro->_id ?>'">
            ✏️ Modificar
        </button>

        <?php if (!$esEsteUsuario): ?>
            <button type="button" class="btn btn-danger" onclick="if(confirm('¿Seguro que deseas eliminar al cliente <?= addslashes($cadaRegistro->_nombre . ' ' . $cadaRegistro->_apellido) ?>?')) location.href='/usuarios/borrar/procesar.php?id=<?= $cadaRegistro->_id ?>'">
                🗑️ Eliminar
            </button>
        <?php else: ?>
            <span style="font-size: 0.85rem; color: #888; padding: 6px 10px;">(Tu cuenta)</span>
        <?php endif; ?>
    </nav>
</article>
