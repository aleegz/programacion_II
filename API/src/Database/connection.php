<?php
    namespace Database;

    use PDO;
    use PDOException;

    use Dotenv\Dotenv;

    require_once __DIR__ . '/../../vendor/autoload.php';
    
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();


    class Connection 
    {
        private static $pdo;

        public static function getConnection(): PDO
        {
            if (self::$pdo === null) {
                $host = $_ENV['HOST'];
                $db = $_ENV['DB'];
                $port = $_ENV['PORT'];
                $charset = 'utf8mb4';
                $username = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASS'];

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
