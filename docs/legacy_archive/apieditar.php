<?php

header('Content-Type: application/json; charset=utf-8');

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

$raiz = realpath(__DIR__);

function responder($datos, $codigo = 200)
{
    http_response_code($codigo);
    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
    exit;
}

/*
 * Convierte una ruta relativa en una ruta absoluta
 * y evita salir de $raiz mediante ../
 */
function rutaSegura($ruta)
{
    global $raiz;

    $ruta = str_replace('\\', '/', $ruta);
    $ruta = ltrim($ruta, '/');

    if ($ruta === '' || stripos($ruta, '..')!==false) {
        return false;
    }

    return $raiz . DIRECTORY_SEPARATOR .
           str_replace('/', DIRECTORY_SEPARATOR, $ruta);
}


/*
 * LISTAR ARCHIVOS
 */
function listar($directorio, $relativo = '')
{
    $resultado = [];

    $items = scandir($directorio);

    foreach ($items as $item) {

        if ($item === '.' || $item === '..') {
            continue;
        }

        // No mostrar la propia API
        if ($item === 'apieditar.php') {
            continue;
        }
        if ($item === 'editar.php') {
            continue;
        }

        $ruta = $directorio . DIRECTORY_SEPARATOR . $item;

        $rutaRelativa = $relativo === ''
            ? $item
            : $relativo . '/' . $item;

        if (is_dir($ruta)) {

            $resultado[] = [
                'tipo' => 'directorio',
                'nombre' => $item,
                'ruta' => $rutaRelativa,
                'hijos' => listar($ruta, $rutaRelativa)
            ];

        } else {

            $resultado[] = [
                'tipo' => 'archivo',
                'nombre' => $item,
                'ruta' => $rutaRelativa
            ];
        }
    }

    return $resultado;
}


switch ($accion) {

    /*
     * -----------------------------------------
     * LISTAR
     * -----------------------------------------
     */
    case 'listar':

        responder([
            'ok' => true,
            'archivos' => listar($raiz)
        ]);

        break;


    /*
     * -----------------------------------------
     * LEER
     * -----------------------------------------
     */
    case 'leer':

        $ruta = $_GET['ruta'] ?? '';

        $archivo = rutaSegura($ruta);

        if (!$archivo || !is_file($archivo)) {
            responder([
                'ok' => false,
                'error' => 'Archivo no encontrado'
            ], 404);
        }

        $contenido = file_get_contents($archivo);

        responder([
            'ok' => true,
            'ruta' => $ruta,
            'contenido' => $contenido
        ]);

        break;


    /*
     * -----------------------------------------
     * GUARDAR
     * -----------------------------------------
     */
    case 'guardar':

        $ruta = $_POST['ruta'] ?? '';
        $contenido = $_POST['contenido'] ?? '';

        $archivo = rutaSegura($ruta);

        if (!$archivo) {
            responder([
                'ok' => false,
                'error' => 'Ruta inválida'
            ], 400);
        }

        if (!is_file($archivo)) {
            responder([
                'ok' => false,
                'error' => 'El archivo no existe'
            ], 404);
        }

        if (file_put_contents($archivo, $contenido) === false) {

            responder([
                'ok' => false,
                'error' => 'No se pudo guardar'
            ], 500);
        }

        responder([
            'ok' => true,
            'mensaje' => 'Archivo guardado'
        ]);

        break;


    /*
     * -----------------------------------------
     * CREAR
     * -----------------------------------------
     */
    case 'crear':

        $ruta = $_POST['ruta'] ?? '';
        $contenido = $_POST['contenido'] ?? '';

        $archivo = rutaSegura($ruta);

        if (!$archivo) {
            responder([
                'ok' => false,
                'error' => 'Ruta inválida'
            ], 400);
        }

        if (file_exists($archivo)) {

            responder([
                'ok' => false,
                'error' => 'El archivo ya existe'
            ], 409);
        }

        /*
         * Crear directorios intermedios si hacen falta
         *
         * Ejemplo:
         * css/nuevo.css
         */
        $directorio = dirname($archivo);

        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }

        if (file_put_contents($archivo, $contenido) === false) {

            responder([
                'ok' => false,
                'error' => 'No se pudo crear el archivo'
            ], 500);
        }

        responder([
            'ok' => true,
            'mensaje' => 'Archivo creado'
        ]);

        break;


    /*
     * -----------------------------------------
     * ELIMINAR
     * -----------------------------------------
     */
    case 'eliminar':

        $ruta = $_POST['ruta'] ?? '';

        $archivo = rutaSegura($ruta);

        if (!$archivo || !is_file($archivo)) {

            responder([
                'ok' => false,
                'error' => 'Archivo no encontrado'
            ], 404);
        }

        if (!unlink($archivo)) {

            responder([
                'ok' => false,
                'error' => 'No se pudo eliminar'
            ], 500);
        }

        responder([
            'ok' => true,
            'mensaje' => 'Archivo eliminado'
        ]);

        break;


    default:

        responder([
            'ok' => false,
            'error' => 'Acción no válida'
        ], 400);
}