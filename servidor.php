<?php
$puerto = 3000;
$menu = "---------------\n1) Iniciar servidor\n2) Abrir chrome en http://localhost:$puerto\n3) Abrir VSCode\n4) Abrir carpeta\n5) Abrir línea de comandos\n6) Abrir php.ini\n0) Salir\n";

/**
 * Construye el comando para iniciar el servidor integrado de PHP con pdo_sqlite habilitado.
 */
function construirComandoServidor(int $puerto): string {
    $phpBin = escapeshellarg(PHP_BINARY);
    $extFlags = '';
    if (!extension_loaded('pdo_sqlite')) {
        $extDir = dirname(PHP_BINARY) . DIRECTORY_SEPARATOR . 'ext';
        if (is_dir($extDir)) {
            $extFlags .= ' -d extension_dir=' . escapeshellarg($extDir);
        }
        $extFlags .= ' -d extension=pdo_sqlite';
    }
    return "cmd /c start \"\" $phpBin$extFlags -S 0.0.0.0:$puerto -t publica/";
}

/**
 * Abre el archivo php.ini activo o informa dónde crearlo si aún no existe.
 */
function abrirPhpIni(): void {
    $iniPath = php_ini_loaded_file();
    if ($iniPath && file_exists($iniPath)) {
        exec('start "" notepad ' . escapeshellarg($iniPath));
        return;
    }

    $carpetaPhp = dirname(PHP_BINARY);
    $candidato = $carpetaPhp . DIRECTORY_SEPARATOR . 'php.ini';
    if (file_exists($candidato)) {
        exec('start "" notepad ' . escapeshellarg($candidato));
        return;
    }

    print("No hay un php.ini creado todavía.\nPodés crear uno copiando php.ini-development a php.ini en:\n$carpetaPhp\n");
}

print $menu;
$r = readline("Elegí una opción: ");
while ($r !== false && trim($r) !== '0') {
    $opcion = trim($r);
    if ($opcion === '1') {
        pclose(popen(construirComandoServidor($puerto), 'r'));
        exec("start chrome http://localhost:$puerto/");
    } elseif ($opcion === '2') {
        exec("start chrome http://localhost:$puerto/");
    } elseif ($opcion === '3') {
        exec('start code .');
    } elseif ($opcion === '4') {
        exec('start explorer .');
    } elseif ($opcion === '5') {
        exec('start cmd /k cd .');
    } elseif ($opcion === '6') {
        abrirPhpIni();
    } else {
        print("Opción no válida\n");
    }
    print $menu;
    $r = readline("Elegí una opción: ");
}
