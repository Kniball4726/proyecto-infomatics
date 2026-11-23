<?php
/** @var string $titulo */
$titulo = $titulo ?? 'InfoMatics Computación';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
<title><?= htmlspecialchars($titulo) ?></title>
<link rel="icon" href="/recursos/logo.png" type="image/png">

<!-- Script temprano para evitar parpadeo blanco (FOUC) -->
<script>
    (function() {
        var guardado = localStorage.getItem('infomatics_theme');
        var pref = guardado || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', pref);
    })();
</script>

<link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=red">
<style>
    /* ================= ESTILOS BASE ================= */
    header.cabecera-pro {
        padding: 0;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        border: 1px solid rgba(0,0,0,0.1);
    }
    .navbar-pro {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.85rem 1.5rem;
        background: #1e1e1e;
        color: #ffffff;
        flex-wrap: wrap;
        gap: 12px;
    }
    .brand-pro {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: white;
        cursor: pointer;
    }
    .brand-pro img {
        height: 42px;
        width: auto;
        object-fit: contain;
    }
    .brand-pro span {
        font-size: 1.45rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .nav-actions-pro {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .user-badge-pro {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
        background: #2a2a2a;
        color: #e0e0e0;
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid #444;
    }
    .hero-pro {
        position: relative;
        background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.7)), url('/recursos/portada.png') center/cover no-repeat;
        padding: 3.5rem 2rem;
        color: #ffffff;
        text-align: center;
    }
    .hero-pro h1 {
        margin: 0;
        font-size: 2.3rem;
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0,0,0,0.8);
    }
    .hero-pro p {
        margin: 0.6rem 0 0;
        font-size: 1.15rem;
        color: #f0f0f0;
        text-shadow: 0 1px 5px rgba(0,0,0,0.7);
    }
    .btn-toggle-theme {
        background: #2a2a2a;
        border: 1px solid #555;
        color: #f0f0f0;
        border-radius: 20px;
        padding: 6px 14px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-toggle-theme:hover {
        background: #3a3a3a;
        border-color: #888;
    }

    /* ================= DARK MODE OVERRIDES ================= */
    html[data-theme="dark"] {
        color-scheme: dark;
        --bg: #121212 !important;
        --accent-bg: #1e1e1e !important;
        --text: #e0e0e0 !important;
        --text-light: #aaaaaa !important;
        --border: #333333 !important;
        background-color: #121212 !important;
        color: #e0e0e0 !important;
    }
    html[data-theme="dark"] body {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
    }
    html[data-theme="dark"] article, 
    html[data-theme="dark"] .ficha-producto, 
    html[data-theme="dark"] .resumen-card,
    html[data-theme="dark"] .imagen-contenedor {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
        border-color: #333333 !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.4) !important;
    }
    html[data-theme="dark"] h1, 
    html[data-theme="dark"] h2, 
    html[data-theme="dark"] h3 {
        color: #ffffff !important;
    }
    html[data-theme="dark"] p,
    html[data-theme="dark"] label {
        color: #dcdcdc !important;
    }
    html[data-theme="dark"] input:not([type="submit"]):not([type="button"]),
    html[data-theme="dark"] textarea,
    html[data-theme="dark"] select {
        background-color: #262626 !important;
        color: #ffffff !important;
        border-color: #444444 !important;
    }
    html[data-theme="dark"] input[readonly] {
        background-color: #1c1c1c !important;
        color: #ff5252 !important;
    }
    html[data-theme="dark"] .categoria-badge {
        background: #333333 !important;
        color: #cfcfcf !important;
    }
    html[data-theme="dark"] .barra-superior {
        border-bottom-color: #333333 !important;
    }
    html[data-theme="dark"] .btn-volver {
        border-color: #555555 !important;
        color: #cccccc !important;
    }
    html[data-theme="dark"] .btn-volver:hover {
        background-color: #2a2a2a !important;
        color: #ffffff !important;
    }
    html[data-theme="dark"] .btn-toggle-theme {
        background: #333333;
        border-color: #666;
        color: #ffd54f;
    }
</style>

<script>
    function toggleTheme() {
        var actual = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        var nuevo = actual === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', nuevo);
        localStorage.setItem('infomatics_theme', nuevo);
        actualizarBotonesTheme();
    }

    function actualizarBotonesTheme() {
        var esDark = document.documentElement.getAttribute('data-theme') === 'dark';
        var botones = document.querySelectorAll('.btn-toggle-theme');
        botones.forEach(function(btn) {
            btn.innerHTML = esDark ? '☀️ Modo Claro' : '🌙 Modo Oscuro';
            btn.setAttribute('title', esDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
        });
    }

    document.addEventListener('DOMContentLoaded', actualizarBotonesTheme);
</script>
