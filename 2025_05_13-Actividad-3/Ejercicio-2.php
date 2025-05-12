<?php
$sql = "CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    precio DECIMAL(10,2)
)";
$pdo->exec($sql);

$productos = [
    ['Manzana', 5.00],
    ['Naranja', 3.00],
    ['Limón', 7.00]
];

$stmt = $pdo->prepare("INSERT INTO productos(nombre, precio) VALUES (?, ?)");
foreach ($productos as $producto) {
    $stmt->execute($producto);
}

$stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC");
$productosDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($productosDB);
?>