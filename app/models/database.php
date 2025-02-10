<?php
require_once "config.php";

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            $conn_string = "host=" . DB_HOST . " port=" . DB_PORT . " dbname=" . DB_NAME . 
                           " user=" . DB_USER . " password=" . DB_PASSWORD;
            self::$connection = pg_connect($conn_string);

            if (!self::$connection) {
                die("Erreur de connexion à la base de données.");
            }
        }
        return self::$connection;
    }

    public static function close() {
        if (self::$connection !== null) {
            pg_close(self::$connection);
            self::$connection = null;
        }
    }
}
?>
