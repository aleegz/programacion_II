<?php
interface Reproducible {
    public function reproducir();
}

class Pelicula implements Reproducible {
    public function reproducir() {
        echo "Reproduciendo película...\n";
    }
}

class Podcast implements Reproducible {
    public function reproducir() {
        echo "Reproduciendo podcast...\n";
    }
}

$medios = [new Pelicula(), new Podcast()];
foreach ($medios as $medio) {
    $medio->reproducir();
}
?>
