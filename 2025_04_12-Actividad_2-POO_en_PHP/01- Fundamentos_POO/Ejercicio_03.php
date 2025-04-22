<?php
class Estudiante {
    public $nombre;
    public $edad;
    public $matricula;

    public function mostrarDatos() {
        echo "Nombre: {$this->nombre}\n";
        echo "Edad: {$this->edad}\n";
        echo "Matrícula: {$this->matricula}\n";
    }
}

$estudiante = new Estudiante();
$estudiante->nombre = "Ana Pérez";
$estudiante->edad = 20;
$estudiante->matricula = "20231001";

$estudiante->mostrarDatos();
?>
