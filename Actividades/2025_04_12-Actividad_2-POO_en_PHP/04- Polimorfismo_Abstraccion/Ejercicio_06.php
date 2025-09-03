<?php
abstract class Trabajador {
    abstract public function calcularIngreso();
}

class Fijo extends Trabajador {
    private $salarioMensual;

    public function __construct($salarioMensual) {
        $this->salarioMensual = $salarioMensual;
    }

    public function calcularIngreso() {
        return $this->salarioMensual;
    }
}

class Temporal extends Trabajador {
    private $horasTrabajadas;
    private $pagoPorHora;

    public function __construct($horasTrabajadas, $pagoPorHora) {
        $this->horasTrabajadas = $horasTrabajadas;
        $this->pagoPorHora = $pagoPorHora;
    }

    public function calcularIngreso() {
        return $this->horasTrabajadas * $this->pagoPorHora;
    }
}

$trabajadores = [new Fijo(2000), new Temporal(100, 15)];
foreach ($trabajadores as $trabajador) {
    echo "Ingreso: " . $trabajador->calcularIngreso() . "\n";
}
?>
