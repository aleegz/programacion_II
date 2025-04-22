<?php
interface Nadador {
    public function nadar();
}

class Pez implements Nadador {
    public function nadar() {
        echo "El pez nada rápidamente.";
    }
}

class Persona implements Nadador {
    public function nadar() {
        echo "El ser humano nada.";
    }
}

$pez = new Pez();
$pez->nadar();

$persona = new Persona();
$persona->nadar();
?>