<?php
class Vehiculo {
    private $kilometros;

    public function __construct($kilometros = 0) {
        $this->kilometros = $kilometros;
    }

    public function getKilometros() {
        return $this->kilometros;
    }

    public function avanzar($km) {
        if ($km > 0) {
            $this->kilometros += $km;
        }
    }
}

$vehiculo = new Vehiculo();
$vehiculo->avanzar(50);
echo "Kilómetros recorridos: " . $vehiculo->getKilometros() . "\n";

$vehiculo->avanzar(-10); // No suma
echo "Kilómetros tras intento inválido: " . $vehiculo->getKilometros() . "\n";
?>
