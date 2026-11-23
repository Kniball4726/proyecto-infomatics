<?php
namespace App\Database;

use PDO;

class Connection {
    private static ?PDO $instance = null;

    public static function get(): PDO {
        if (self::$instance === null) {
            $dbPath = dirname(__DIR__, 2) . '/infomatics.db';
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
        }
        return self::$instance;
    }
}
