<?php
class Coche {
    public $marca;
    public $modelo;
    public $color;

    public function detalles() {
        echo "Coche: {$this->marca} {$this->modelo}, Color: {$this->color}.\n";
    }
}

$coche = new Coche();
$coche->marca = "Toyota";
$coche->modelo = "Corolla";
$coche->color = "Rojo";

$coche->detalles();
?>
