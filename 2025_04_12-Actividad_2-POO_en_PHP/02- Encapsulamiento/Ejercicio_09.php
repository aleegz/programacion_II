<?php
class Circulo {
    private $radio;

    public function __construct($radio) {
        $this->setRadio($radio);
    }

    public function getRadio() {
        return $this->radio;
    }

    public function setRadio($radio) {
        if ($radio > 0) {
            $this->radio = $radio;
        } else {
            echo "Error: El radio debe ser positivo.\n";
        }
    }
}

$circulo = new Circulo(5);
echo "Radio: " . $circulo->getRadio() . "\n";

$circulo->setRadio(-3); // Error
?>
