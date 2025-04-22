<?php
class Usuario {
    private $edad;

    public function __construct($edad = null) {
        if ($edad !== null) {
            $this->setEdad($edad);
        }
    }

    public function getEdad() {
        return $this->edad;
    }
    
    public function setEdad($edad) {
        if (is_int($edad) && $edad > 0) {
            $this->edad = $edad;
        } else {
            echo "Error: La edad debe ser un número entero mayor a 0.<br>";
        }
    }
}

$usuario = new Usuario();
$usuario->setEdad(20);
$usuario->setEdad(-5);
$usuario->setEdad("helloworld");
?>