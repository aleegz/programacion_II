<?php
class Persona {
    public $nombre;
    public $edad;

    public function esAdulto() {
        return $this->edad >= 18;
    }
}

$persona = new Persona();
$persona->nombre = "Luis";
$persona->edad = 17;

if ($persona->esAdulto()) {
    echo "{$persona->nombre} es adulto.\n";
} else {
    echo "{$persona->nombre} no es adulto.\n";
}
?>
