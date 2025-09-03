<?php
class Vehiculo {
    public $velocidad = 0;

    public function acelerar() {
        $this->velocidad += 5;
    }
}

class Camion extends Vehiculo {
    public function acelerar() {
        $this->velocidad += 10;
    }
}

$camion = new Camion();
$camion->acelerar();
echo "Velocidad del camión: " . $camion->velocidad . "\n";
?>
