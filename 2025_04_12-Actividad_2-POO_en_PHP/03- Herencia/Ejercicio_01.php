<?php
class Vehiculo {
    public $marca;

    public function avanzar() {
        echo "El vehículo {$this->marca} está avanzando.\n";
    }
}

class Moto extends Vehiculo {
    public $cilindrada;

    public function avanzar() {
        echo "La moto {$this->marca} de {$this->cilindrada}cc está avanzando rápidamente.\n";
    }
}

$moto = new Moto();
$moto->marca = "Honda";
$moto->cilindrada = 250;
$moto->avanzar();
?>
