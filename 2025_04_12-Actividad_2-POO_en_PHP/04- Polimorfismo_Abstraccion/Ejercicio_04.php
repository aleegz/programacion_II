<?php
abstract class Figuras {
    abstract public function area();
}

class Triangulo extends Figuras {
    public $base;
    public $altura;

    public function __construct($base, $altura) {
        $this->base = $base;
        $this->altura = $altura;
    }

    public function area() {
        return ($this->base * $this->altura) / 2;
    }
}

class Circulo extends Figuras {
    public $radio;

    public function __construct($radio) {
        $this->radio = $radio;
    }

    public function area() {
        return pi() * $this->radio * $this->radio;
    }
}

$figuras = [new Triangulo(3, 4), new Circulo(5)];
foreach ($figuras as $figura) {
    echo "Área: " . $figura->area() . "\n";
}
?>
