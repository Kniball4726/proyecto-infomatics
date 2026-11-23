<?php
/**
 * Conexión y utilidades de Base de Datos (Delegado a App\Database\Connection)
 */
require_once __DIR__ . '/../app/Database/Connection.php';

use App\Database\Connection;

function getDB(): PDO {
    return Connection::get();
}
