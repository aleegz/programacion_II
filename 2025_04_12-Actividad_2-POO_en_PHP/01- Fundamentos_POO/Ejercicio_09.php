<?php
class Trabajador {
    public $nombre;
    public $cargo;
    public $salario;

    public function informacion() {
        echo "Nombre: {$this->nombre}\n";
        echo "Cargo: {$this->cargo}\n";
        echo "Salario: $" . number_format($this->salario, 2) . "\n";
    }
}

$trabajador = new Trabajador();
$trabajador->nombre = "María López";
$trabajador->cargo = "Contadora";
$trabajador->salario = 3500.75;

$trabajador->informacion();
?>
