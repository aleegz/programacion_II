<?php
class Rectangulo {
    public $largo;
    public $ancho;
    
    public function calcularArea() {
        return $this->largo * $this->ancho;
    }
}

$rectangulo = new Rectangulo();
$rectangulo->largo = 10;
$rectangulo->ancho = 5;

$area = $rectangulo->calcularArea();
echo "El área del rectángulo es: " . $area;
?>