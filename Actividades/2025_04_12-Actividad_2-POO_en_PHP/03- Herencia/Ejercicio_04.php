<?php
abstract class Figura {
    abstract public function calcularArea();
}

class Cuadrado extends Figura {
    public $lado;

    public function __construct($lado) {
        $this->lado = $lado;
    }

    public function calcularArea() {
        return $this->lado * $this->lado;
    }
}

$cuadrado = new Cuadrado(5);
echo "Área del cuadrado: " . $cuadrado->calcularArea() . "\n";
?>
