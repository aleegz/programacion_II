<?php
class Circulo {
    public $radio;

    public function calcularPerimetro() {
        return 2 * pi() * $this->radio;
    }
}

$circulo = new Circulo();
$circulo->radio = 7;

echo "El perímetro del círculo es: " . $circulo->calcularPerimetro() . "\n";
?>
