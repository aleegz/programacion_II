<?php
$sql = "CREATE TABLE cuentas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    saldo DECIMAL(10,2)
)";
$pdo->exec($sql);

$pdo->exec("INSERT INTO cuentas(saldo) VALUES (1000), (500)");

$monto = 100;
$cuentaOrigen = 1;
$cuentaDestino = 99;

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("UPDATE cuentas SET saldo = saldo - :monto WHERE id = :id");
    $stmt->execute([':monto' => $monto, ':id' => $cuentaOrigen]);

    $stmt = $pdo->prepare("UPDATE cuentas SET saldo = saldo + :monto WHERE id = :id");
    $stmt->execute([':monto' => $monto, ':id' => $cuentaDestino]);

    $pdo->commit();
    echo "Transferencia completada.";
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log($e->getMessage());
    echo "Error en la transferencia. Se ha revertido la operación.";
}
?>