<?php
class Producto {
    public $nombre;
    public $precio;
    public $stock;

    public function valorInventario() {
        return $this->precio * $this->stock;
    }
}

$producto = new Producto();
$producto->nombre = "Teclado";
$producto->precio = 50;
$producto->stock = 20;

echo "Valor total del inventario: $" . $producto->valorInventario() . "\n";
?>
