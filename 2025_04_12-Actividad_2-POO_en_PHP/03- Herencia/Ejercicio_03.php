<?php
class Persona {
    public $nombre;
    public $edad;

    public function saludar() {
        echo "Hola, soy {$this->nombre} y tengo {$this->edad} años.\n";
    }
}

class Profesor extends Persona {
    public $materia;

    public function saludar() {
        echo "Hola, soy {$this->nombre}, tengo {$this->edad} años y enseño {$this->materia}.\n";
    }
}

$profesor = new Profesor();
$profesor->nombre = "Juan";
$profesor->edad = 40;
$profesor->materia = "Matemáticas";
$profesor->saludar();
?>
