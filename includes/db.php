<?php
/**
 * Conexión y utilidades de Base de Datos
 */

function getDB(): PDO {
    static $db = null;
    if ($db === null) {
        $rutaBD = __DIR__ . '/../infomatics.db';
        $db = new PDO("sqlite:$rutaBD", null, null, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
    }
    return $db;
}
