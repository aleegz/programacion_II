<?php
class AnimalDomesticado {
    public $especie;

    public function emitirSonido() {
        echo "El animal hace un sonido.\n";
    }
}

class Gato extends AnimalDomesticado {
    public function emitirSonido() {
        echo "¡Miau!\n";
    }
}

$gato = new Gato();
$gato->emitirSonido();
?>
