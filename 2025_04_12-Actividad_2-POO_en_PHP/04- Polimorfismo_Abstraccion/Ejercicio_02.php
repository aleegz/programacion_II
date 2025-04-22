<?php
abstract class VehiculoAbstracto {
    abstract public function desplazarse();
}

class Bicicleta extends VehiculoAbstracto {
    public function desplazarse() {
        echo "Se desplaza a las pedaleadas.";
    }
}

class Avion extends VehiculoAbstracto {
    public function desplazarse() {
        echo "Se desplaza por el aire.";
    }
}

$vehiculos = [
    new Bicicleta(),
    new Avion()
];

foreach ($vehiculos as $vehiculo) {
    $vehiculo->desplazarse();
}
?>