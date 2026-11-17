<article id="idArticulo_<?= $cadaRegistro->_id ?>" >
    <h2><?= $cadaRegistro->_nombre ?></h2>
    <nav>
        <button onclick="location.href='/usuarios/ver?id=<?= $cadaRegistro->_id ?>'">Más info</button>
    </nav>
</article>
