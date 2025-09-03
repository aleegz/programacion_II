<?php
$nombreBuscado = 'Naranja';

$sql = "SELECT * FROM productos WHERE nombre = :nombre";
$stmt = $pdo->prepare($sql);
$stmt->execute([':nombre' => $nombreBuscado]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($producto) {
    print_r($producto);
} else {
    echo "Producto no encontrado.";
}
?>