<?php
namespace App\Database;

use PDO;

class Connection {
    private static ?PDO $instance = null;

    public static function get(): PDO {
        if (self::$instance === null) {
            $dbPath = getenv('DB_PATH') ?: (dirname(__DIR__, 2) . '/infomatics.db');
            $debeInicializar = !file_exists($dbPath) || filesize($dbPath) === 0;

            self::$instance = new PDO("sqlite:$dbPath", null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);

            if ($debeInicializar) {
                $schemaFile = __DIR__ . '/schema.sql';
                if (file_exists($schemaFile)) {
                    $sql = file_get_contents($schemaFile);
                    self::$instance->exec($sql);
                }
            }

            // Asegurar tablas de pedidos en bases de datos existentes
            self::$instance->exec("
                CREATE TABLE IF NOT EXISTS TPedidos (
                    _id INTEGER PRIMARY KEY AUTOINCREMENT,
                    _idUsuario INTEGER NOT NULL REFERENCES TUsuarios(_id),
                    _total REAL NOT NULL,
                    _estado TEXT NOT NULL DEFAULT 'Completado',
                    _fecha DATETIME DEFAULT CURRENT_TIMESTAMP
                );
                CREATE TABLE IF NOT EXISTS TDetallePedido (
                    _id INTEGER PRIMARY KEY AUTOINCREMENT,
                    _idPedido INTEGER NOT NULL REFERENCES TPedidos(_id) ON DELETE CASCADE,
                    _idProducto INTEGER NOT NULL REFERENCES TProductos(_id),
                    _cantidad INTEGER NOT NULL,
                    _precioUnitario REAL NOT NULL,
                    _subtotal REAL NOT NULL
                );
            ");
        }
        return self::$instance;
    }
}
