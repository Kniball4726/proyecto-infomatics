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
    /* ================= SISTEMA GLOBAL Y PROFESIONAL DE BOTONES ================= */
    button, 
    input[type="button"], 
    input[type="submit"], 
    .btn {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji" !important;
        font-size: 0.90rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.3px;
        line-height: 1 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        height: 38px !important;
        min-height: 38px !important;
        padding: 0 16px !important;
        border-radius: 8px !important;
        border: 1px solid #d1d5db;
        background-color: #f3f4f6;
        color: #374151 !important;
        text-decoration: none !important;
        cursor: pointer !important;
        user-select: none;
        white-space: nowrap;
        box-sizing: border-box !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        vertical-align: middle;
    }

    button:hover, 
    input[type="button"]:hover, 
    input[type="submit"]:hover, 
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        background-color: #e5e7eb;
        color: #111827 !important;
        border-color: #9ca3af;
    }

    button:active, 
    input[type="button"]:active, 
    input[type="submit"]:active, 
    .btn:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    button:focus-visible, 
    input[type="button"]:focus-visible, 
    input[type="submit"]:focus-visible, 
    .btn:focus-visible {
        outline: 2px solid #d32f2f;
        outline-offset: 2px;
    }

    /* Variantes semánticas coherentes */
    .btn-primary {
        background-color: #d32f2f !important;
        border-color: #b71c1c !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(211, 47, 47, 0.25) !important;
    }
    .btn-primary:hover {
        background-color: #b71c1c !important;
        border-color: #9e1414 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(211, 47, 47, 0.4) !important;
    }

    .btn-success {
        background-color: #2e7d32 !important;
        border-color: #1b5e20 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(46, 125, 50, 0.25) !important;
    }
    .btn-success:hover {
        background-color: #1b5e20 !important;
        border-color: #144717 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.4) !important;
    }

    .btn-info {
        background-color: #0277bd !important;
        border-color: #01579b !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(2, 119, 189, 0.25) !important;
    }
    .btn-info:hover {
        background-color: #01579b !important;
        border-color: #00447a !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(2, 119, 189, 0.4) !important;
    }

    .btn-danger {
        background-color: #c62828 !important;
        border-color: #8e0000 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(198, 40, 40, 0.25) !important;
    }
    .btn-danger:hover {
        background-color: #8e0000 !important;
        border-color: #630000 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(198, 40, 40, 0.4) !important;
    }

    .btn-secondary,
    .btn-outline {
        background-color: transparent !important;
        border: 1px solid #777777 !important;
        color: #444444 !important;
    }
    .btn-secondary:hover,
  .btn-outline:hover {
        background-color: rgba(0, 0, 0, 0.05) !important;
        border-color: #444444 !important;
        color: #111111 !important;
    }

    /* Modificadores de tamaño manteniendo misma tipografía y radio */
    .btn-sm {
        height: 32px !important;
        min-height: 32px !important;
        padding: 0 12px !important;
        font-size: 0.82rem !important;
        border-radius: 6px !important;
    }
    .btn-lg {
        height: 44px !important;
        min-height: 44px !important;
        padding: 0 24px !important;
        font-size: 1rem !important;
        border-radius: 8px !important;
    }
    .btn-icon {
        width: 34px !important;
        height: 34px !important;
        min-height: 34px !important;
        padding: 0 !important;
        border-radius: 6px !important;
        font-size: 1.15rem !important;
    }

    /* Botón Modo Oscuro */
    .btn-toggle-theme {
        background: #2a2a2a !important;
        border: 1px solid #555555 !important;
        color: #f0f0f0 !important;
        border-radius: 8px !important;
        padding: 0 14px !important;
        height: 38px !important;
        cursor: pointer !important;
        font-size: 0.88rem !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
        transition: all 0.2s ease !important;
    }
    .btn-toggle-theme:hover {
        background: #3a3a3a !important;
        border-color: #888888 !important;
        color: #ffffff !important;
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
        background: #2a2a2a !important;
        border-color: #555555 !important;
        color: #ffd54f !important;
    }
    html[data-theme="dark"] .btn-toggle-theme:hover {
        background: #383838 !important;
        border-color: #777777 !important;
    }

    /* ================= SISTEMA DE NOTIFICACIONES TOAST ================= */
    .toast-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-width: 400px;
        pointer-events: none;
    }
    .toast-notification {
        pointer-events: auto;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.92rem;
        font-weight: 600;
        line-height: 1.4;
        box-shadow: 0 8px 24px rgba(0,0,0,0.22);
        animation: toastEntrada 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    @keyframes toastEntrada {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .toast-success {
        background-color: #1b5e20 !important;
        color: #ffffff !important;
        border: 1px solid #2e7d32;
    }
    .toast-error {
        background-color: #b71c1c !important;
        color: #ffffff !important;
        border: 1px solid #c62828;
    }
    .toast-info {
        background-color: #01579b !important;
        color: #ffffff !important;
        border: 1px solid #0288d1;
    }
    .toast-close {
        background: transparent !important;
        border: none !important;
        color: #ffffff !important;
        font-size: 1.1rem !important;
        height: auto !important;
        min-height: auto !important;
        padding: 0 !important;
        cursor: pointer !important;
        margin-left: auto;
        opacity: 0.7;
        box-shadow: none !important;
        transform: none !important;
    }
    .toast-close:hover {
        opacity: 1;
        background: transparent !important;
        box-shadow: none !important;
        transform: none !important;
    }

    /* Botones genéricos y secundarios en Dark Mode */
    html[data-theme="dark"] button:not(.btn-primary):not(.btn-success):not(.btn-info):not(.btn-danger):not(.btn-toggle-theme),
    html[data-theme="dark"] input[type="button"]:not(.btn-primary):not(.btn-success):not(.btn-info):not(.btn-danger),
    html[data-theme="dark"] input[type="submit"]:not(.btn-primary):not(.btn-success):not(.btn-info):not(.btn-danger),
    html[data-theme="dark"] .btn-secondary,
    html[data-theme="dark"] .btn-outline {
        background-color: #252525 !important;
        border-color: #4a4a4a !important;
        color: #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) !important;
    }

    html[data-theme="dark"] button:not(.btn-primary):not(.btn-success):not(.btn-info):not(.btn-danger):not(.btn-toggle-theme):hover,
    html[data-theme="dark"] input[type="button"]:not(.btn-primary):not(.btn-success):not(.btn-info):not(.btn-danger):hover,
    html[data-theme="dark"] input[type="submit"]:not(.btn-primary):not(.btn-success):not(.btn-info):not(.btn-danger):hover,
    html[data-theme="dark"] .btn-secondary:hover,
    html[data-theme="dark"] .btn-outline:hover {
        background-color: #333333 !important;
        border-color: #666666 !important;
        color: #ffffff !important;
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

    function mostrarToast(mensaje, tipo) {
        tipo = tipo || 'info';
        var cont = document.querySelector('.toast-container');
        if (!cont) {
            cont = document.createElement('div');
            cont.className = 'toast-container';
            document.body.appendChild(cont);
        }
        var toast = document.createElement('div');
        toast.className = 'toast-notification toast-' + tipo;
        toast.innerHTML = '<span>' + mensaje + '</span><button type="button" class="toast-close" onclick="this.parentElement.remove()" title="Cerrar">✕</button>';
        cont.appendChild(toast);
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(function() { toast.remove(); }, 350);
        }, 4500);
    }
</script>
<?php
$flashToast = $_SESSION['toast'] ?? null;
unset($_SESSION['toast']);
if ($flashToast && !empty($flashToast['mensaje'])):
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        mostrarToast(<?= json_encode($flashToast['mensaje']) ?>, <?= json_encode($flashToast['tipo'] ?? 'info') ?>);
    });
</script>
<?php endif; ?>
