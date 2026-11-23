<?php
/** @var string|null $error */
/** @var array $datos */
use App\Services\CsrfService;
$datos = $datos ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    $titulo = 'Crear Cuenta - InfoMatics';
    require __DIR__ . '/../layout/head.php'; 
    ?>
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
            max-width: 480px;
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
            margin-bottom: 1.2rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
            }
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
            padding: 10px 14px;
            font-size: 0.95rem;
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
            <button type="button" class="btn btn-toggle-theme" onclick="toggleTheme()">🌙 Modo Oscuro</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='/'" style="border-color: #666; color: #e0e0e0 !important;">
                ← Volver a la tienda
            </button>
        </div>
    </header>

    <main class="login-wrapper">
        <div class="login-card">
            <img src="/recursos/logo.png" alt="InfoMatics" class="login-logo">
            <h1 class="login-title">Crear Cuenta</h1>
            <p class="login-subtitle">Regístrate para comprar componentes y armar tu carrito</p>

            <?php if (!empty($error)): ?>
                <div class="alert-error">
                    ⚠️ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="/registro-procesar.php" method="POST">
                <?= CsrfService::campoHtml() ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="idNombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="idNombre" value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>" placeholder="Ej: Juan" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="idApellido">Apellido:</label>
                        <input type="text" class="form-control" name="apellido" id="idApellido" value="<?= htmlspecialchars($datos['apellido'] ?? '') ?>" placeholder="Ej: Pérez" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="idEmail">Correo Electrónico:</label>
                    <input type="email" class="form-control" name="email" id="idEmail" value="<?= htmlspecialchars($datos['email'] ?? '') ?>" placeholder="nombre@correo.com" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="idClave">Contraseña:</label>
                        <input type="password" class="form-control" name="clave" id="idClave" placeholder="Mínimo 4 caracteres" required>
                    </div>
                    <div class="form-group">
                        <label for="idClaveConfirm">Confirmar:</label>
                        <input type="password" class="form-control" name="clave_confirmar" id="idClaveConfirm" placeholder="Repite la clave" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; height: 42px; min-height: 42px; font-size: 0.95rem; margin-top: 0.8rem;">
                    Crear mi cuenta
                </button>
            </form>

            <div class="login-footer-links">
                <span>¿Ya tienes cuenta? <a href="/formulario-login.php">Iniciar Sesión</a></span>
                <a href="/">Volver a la tienda</a>
            </div>
        </div>
    </main>
</body>
</html>
