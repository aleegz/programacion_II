<?php
$sql = "CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    estado VARCHAR(20)
)";
$pdo->exec($sql);

$nuevoEstado = 'activo';
$idUsuario = 1;

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET estado = :estado WHERE id = :id");
    $stmt->execute([
        ':estado' => $nuevoEstado,
        ':id' => $idUsuario
    ]);
    echo "Estado actualizado correctamente.";
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Error al actualizar estado.";
}
?>