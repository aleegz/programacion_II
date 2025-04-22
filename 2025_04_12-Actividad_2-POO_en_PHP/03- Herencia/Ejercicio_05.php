<?php
class ProductoSuper {
    public $nombre;
    public $precio;

    public function detalle() {
        echo "Producto: {$this->nombre}, Precio: \${$this->precio}\n";
    }
}

class ProductoOferta extends ProductoSuper {
    public $descuento;

    public function detalle() {
        $precioConDescuento = $this->precio * (1 - $this->descuento / 100);
        echo "Producto: {$this->nombre}, Precio original: \${$this->precio}, Precio con descuento: \$" . number_format($precioConDescuento, 2) . "\n";
    }
}

$producto = new ProductoOferta();
$producto->nombre = "Auriculares";
$producto->precio = 100;
$producto->descuento = 20;
$producto->detalle();
?>
