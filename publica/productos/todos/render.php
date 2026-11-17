<article id="idArticulo_<?= $cadaRegistro->_id ?>" >
    <h2><?= $cadaRegistro->_nombre ?></h2>
    <p>
        Precio: $ 
        <input type='number' step='0.05' readonly value='<?= $cadaRegistro->_precio ?>'/>
    </p>
    <nav>
        <button onclick="location.href='/productos/ver?id=<?= $cadaRegistro->_id ?>'">Más info</button>
    </nav>
</article>
