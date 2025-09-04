<?php
    namespace Database;

    use PDO;
    use PDOException;

    class Connection 
    {
        private static $pdo;

        public static function getConnection(): PDO
        {
            if (self::$pdo === null) {
                $host = "localhost";
                $db = "p2db";
                $port = 3306;
                $charset = 'utf8mb4';
                $username = "root";
                $password = "admin";

                $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                try {
                    self::$pdo = new PDO($dsn, $username, $password, $options);
                } catch (PDOException $e) {
                    exit('Error al conectarse a la base de datos: ' . $e->getMessage());
                }
            }
            return self::$pdo;
        }
    }
