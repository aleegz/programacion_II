<?php
interface Calculable {
    public function calcularPerimetro();
}

class Cuadrado implements Calculable {
    public $lado;

    public function __construct($lado) {
        $this->lado = $lado;
    }

    public function calcularPerimetro() {
        return 4 * $this->lado;
    }
}

class Circulo implements Calculable {
    public $radio;

    public function __construct($radio) {
        $this->radio = $radio;
    }

    public function calcularPerimetro() {
        return 2 * pi() * $this->radio;
    }
}

$formas = [new Cuadrado(4), new Circulo(3)];
foreach ($formas as $forma) {
    echo "Perímetro: " . $forma->calcularPerimetro() . "\n";
}
?>
