<?php
/**
 * Componentes de Presentación, Layout y Dark Mode (Delegado a app/Views/layout/)
 */
require_once __DIR__ . '/../app/Services/AuthService.php';
require_once __DIR__ . '/../app/Services/CarritoService.php';

function renderHead(string $titulo = 'InfoMatics Computación'): void {
    require __DIR__ . '/../app/Views/layout/head.php';
}

function renderNavbar(): void {
    require __DIR__ . '/../app/Views/layout/navbar.php';
}

function renderHero(string $titulo = 'Componentes & Tecnología de Alto Rendimiento', string $subtitulo = 'Explora nuestro catálogo con los mejores precios y stock actualizado'): void {
    $tituloHero = $titulo;
    $subtituloHero = $subtitulo;
    require __DIR__ . '/../app/Views/layout/hero.php';
}

function renderHeaderCompleto(string $tituloHero = 'Componentes & Tecnología de Alto Rendimiento', string $subtituloHero = 'Explora nuestro catálogo con los mejores precios y stock actualizado'): void {
    require __DIR__ . '/../app/Views/layout/header_completo.php';
}
