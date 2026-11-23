<?php
/** @var string $tituloHero */
/** @var string $subtituloHero */
$tituloHero = $tituloHero ?? 'Componentes & Tecnología de Alto Rendimiento';
$subtituloHero = $subtituloHero ?? 'Explora nuestro catálogo con los mejores precios y stock actualizado';
?>
<div class="hero-pro">
    <h1><?= htmlspecialchars($tituloHero) ?></h1>
    <p><?= htmlspecialchars($subtituloHero) ?></p>
</div>
