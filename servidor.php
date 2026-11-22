<?php
$dir = addslashes(__DIR__);
$menu = ("---------------------------------------------\n"
       . "           INFOMATICS - PANEL DE CONTROL     \n"
       . "---------------------------------------------\n"
       . "1) Iniciar servidor (segundo plano, sin consola)\n"
       . "2) Detener servidor\n"
       . "3) Abrir navegador en http://localhost:3000\n"
       . "4) Abrir VSCode\n"
       . "5) Abrir carpeta del proyecto\n"
       . "6) Abrir línea de comandos\n"
       . "7) Abrir php.ini\n"
       . "0) Salir\n"
       . "---------------------------------------------\n");

print $menu;
$r = trim(readline("Elegi una opcion: "));

while ($r !== '0') {
    if ($r === '1') {
        // Iniciar PHP Built-in Server en segundo plano sin ventana de consola
        pclose(popen("powershell -WindowStyle Hidden -Command \"Start-Process 'c:\\xampp\\php\\php.exe' -ArgumentList '-S 0.0.0.0:3000 -t publica/' -WorkingDirectory '$dir' -WindowStyle Hidden\"", "r"));
        sleep(1);
        exec("start http://localhost:3000/");
        echo "\n[OK] Servidor iniciado en http://localhost:3000 (sin consola)\n\n";
    } elseif ($r === '2') {
        // Detener servidor
        exec("taskkill /F /IM php.exe >nul 2>&1");
        echo "\n[OK] Servidor detenido.\n\n";
    } elseif ($r === '3') {
        exec("start http://localhost:3000/");
    } elseif ($r === '4') {
        exec("start code .");
    } elseif ($r === '5') {
        exec("start explorer .");
    } elseif ($r === '6') {
        exec("start cmd /k cd .");
    } elseif ($r === '7') {
        exec("start notepad c:\\xampp\\php\\php.ini");
    } else {
        echo "\n[!] Opcion no valida\n\n";
    }

    print $menu;
    $r = trim(readline("Elegi una opcion: "));
}
