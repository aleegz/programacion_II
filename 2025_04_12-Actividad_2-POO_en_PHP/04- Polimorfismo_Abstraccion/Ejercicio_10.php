<?php
abstract class Animal {
    abstract public function alimentarse();
}

class Leon extends Animal {
    public function alimentarse() {
        echo "El león se alimenta de carne.\n";
    }
}

class Pajaro extends Animal {
    public function alimentarse() {
        echo "El pájaro se alimenta de semillas.\n";
    }
}

$animales = [new Leon(), new Pajaro()];
foreach ($animales as $animal) {
    $animal->alimentarse();
}
?>
