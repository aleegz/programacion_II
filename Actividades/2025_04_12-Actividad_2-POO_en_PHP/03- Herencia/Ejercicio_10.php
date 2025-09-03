<?php
class AnimalZoologico {
    public $nombre;

    public function moverse() {
        echo "{$this->nombre} se está moviendo.\n";
    }
}

class Pez extends AnimalZoologico {
    public $tipoAgua;

    public function moverse() {
        echo "{$this->nombre} nada en agua {$this->tipoAgua}.\n";
    }
}

$pez = new Pez();
$pez->nombre = "Nemo";
$pez->tipoAgua = "salada";
$pez->moverse();
?>
