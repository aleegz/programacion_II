<?php
class Database {
    private $pdo;

    public function __construct($host, $db, $user, $pass, $port = 3306) {
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit('Error al conectarse a la base de datos.');
        }
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($email, $estado) {
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (email, estado) VALUES (:email, :estado)");
        $stmt->execute([':email' => $email, ':estado' => $estado]);
        return $this->pdo->lastInsertId();
    }

    public function updateUserEstado($id, $nuevoEstado) {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $nuevoEstado, ':id' => $id]);
    }
}

$db = new Database('localhost', 'prueba', 'root', '');

$id = $db->createUser('correo@ejemplo.com', 'pendiente');

print_r($db->getUserById($id));

$db->updateUserEstado($id, 'activo');
?>