<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/layout.php';

if (estaAutenticado()) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Iniciar Sesión — InfoMatics'); ?>
    <style>
        .barra-nav-login {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 1.5rem;
            background: #1e1e1e;
            color: #ffffff;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            cursor: pointer;
            font-size: 1.3rem;
            font-weight: bold;
        }
        .brand-link img {
            height: 36px;
            width: auto;
            object-fit: contain;
        }
        .login-wrapper {
            max-width: 440px;
            margin: 2rem auto 4rem;
            padding: 0 1rem;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s ease;
        }
        html[data-theme="dark"] .login-card {
            background: #1b1b1b !important;
            border: 1px solid #333333 !important;
            box-shadow: 0 12px 35px rgba(0,0,0,0.6) !important;
        }
        .login-logo {
            height: 55px;
            width: auto;
            object-fit: contain;
            margin-bottom: 0.8rem;
        }
        .login-title {
            margin: 0;
            font-size: 1.65rem;
            font-weight: 700;
            color: #111111;
        }
        html[data-theme="dark"] .login-title {
            color: #ffffff !important;
        }
        .login-subtitle {
            margin: 0.4rem 0 1.8rem;
            font-size: 0.95rem;
            color: #666666;
        }
        html[data-theme="dark"] .login-subtitle {
            color: #aaaaaa !important;
        }
        .form-group {
            text-align: left;
            margin-bottom: 1.3rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #333333;
        }
        html[data-theme="dark"] .form-group label {
            color: #e0e0e0 !important;
        }
        .form-control {
            width: 100%;
            box-sizing: border-box;
            padding: 12px 14px;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #cccccc;
            background: #fafafa;
            color: #111111;
            transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #d32f2f;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(211,47,47,0.2);
        }
        html[data-theme="dark"] .form-control {
            background: #252525 !important;
            color: #ffffff !important;
            border: 1px solid #444444 !important;
        }
        html[data-theme="dark"] .form-control:focus {
            border-color: #ff5252 !important;
            background: #2a2a2a !important;
            box-shadow: 0 0 0 3px rgba(255,82,82,0.25) !important;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 1.05rem;
            font-weight: bold;
            color: #ffffff !important;
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(211,47,47,0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(211,47,47,0.4);
        }
        .alert-error {
            background: #ffebee;
            color: #b71c1c;
            border: 1px solid #ffcdd2;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        html[data-theme="dark"] .alert-error {
            background: #381515 !important;
            color: #ff8a80 !important;
            border-color: #b71c1c !important;
        }
        .login-footer-links {
            margin-top: 1.6rem;
            padding-top: 1.2rem;
            border-top: 1px solid #eeeeee;
            font-size: 0.85rem;
            color: #666666;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        html[data-theme="dark"] .login-footer-links {
            border-top-color: #2e2e2e !important;
            color: #888888 !important;
        }
        .login-footer-links a {
            color: #d32f2f;
            text-decoration: none;
            font-weight: 600;
        }
        html[data-theme="dark"] .login-footer-links a {
            color: #ff5252 !important;
        }
        .login-footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Barra Superior -->
    <header class="barra-nav-login">
        <div class="brand-link" onclick="location.href='/'">
            <img src="/recursos/logo.png" alt="InfoMatics">
            <span>InfoMatics</span>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
            <button onclick="location.href='/'" style="background: transparent; border: 1px solid #777; color: #e0e0e0; padding: 6px 14px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                ← Volver a la tienda
            </button>
        </div>
    </header>

    <main class="login-wrapper">
        <div class="login-card">
            <img src="/recursos/logo.png" alt="InfoMatics" class="login-logo">
            <h1 class="login-title">Iniciar Sesión</h1>
            <p class="login-subtitle">Ingresa tus credenciales para acceder a tu cuenta</p>

            <?php if (!empty($_SESSION["error"])): ?>
                <div class="alert-error">
                    ⚠️ <?= htmlspecialchars($_SESSION["error"]) ?>
                </div>
                <?php unset($_SESSION["error"]); ?>
            <?php endif; ?>

            <form action="/formulario-login-procesar.php" method="POST">
                <div class="form-group">
                    <label for="idUsername">Email o Nombre de usuario:</label>
                    <input type="text" class="form-control" name="nmUsername" id="idUsername" placeholder="ejemplo@correo.com" required autofocus>
                </div>

                <div class="form-group">
                    <label for="idPassword">Contraseña:</label>
                    <input type="password" class="form-control" name="nmPassword" id="idPassword" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit">
                    Entrar a InfoMatics
                </button>
            </form>

            <div class="login-footer-links">
                <a href="/">← Volver al catálogo</a>
                <span>InfoMatics &copy; <?= date('Y') ?></span>
            </div>
        </div>
    </main>
</body>
</html>
