<?php
/**
 * InfoMatics Application Bootstrap
 */

// Autocargador PSR-4 para el namespace App\
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Inicializar sesión de forma segura
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    @session_start();
}
