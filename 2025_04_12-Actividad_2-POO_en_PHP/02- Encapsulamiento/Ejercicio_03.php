<?php
class Producto {
    private $precio;

    public function __construct($precio) {
        $this->setPrecio($precio);
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        if ($precio > 0) {
            $this->precio = $precio;
        } else {
            echo "Error: El precio debe ser positivo.\n";
        }
    }
}

$producto = new Producto(100);
echo "Precio: " . $producto->getPrecio() . "\n";

$producto->setPrecio(-50); // Error
$producto->setPrecio(200);
echo "Precio actualizado: " . $producto->getPrecio() . "\n";
?>
