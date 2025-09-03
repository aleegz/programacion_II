<?php
class Empleado {
    public $nombre;
    public $salario;

    public function calcularPago() {
        return $this->salario;
    }
}

class Freelancer extends Empleado {
    public $horas;
    public $pagoPorHora;

    public function __construct($pagoPorHora) {
        $this->pagoPorHora = $pagoPorHora;
    }

    public function calcularPago() {
        return $this->horas * $this->pagoPorHora;
    }
}

$freelancer = new Freelancer(20);
$freelancer->nombre = "Ana";
$freelancer->horas = 30;
echo "Pago de {$freelancer->nombre}: $" . $freelancer->calcularPago() . "\n";
?>
