<?php
abstract class Instrumentos {
    abstract public function tocar();
}

class Violin extends Instrumentos {
    public function tocar() {
        echo "El violín está sonando.\n";
    }
}

class Bateria extends Instrumentos {
    public function tocar() {
        echo "La batería está sonando.\n";
    }
}

$instrumentos = [new Violin(), new Bateria()];
foreach ($instrumentos as $instrumento) {
    $instrumento->tocar();
}
?>
