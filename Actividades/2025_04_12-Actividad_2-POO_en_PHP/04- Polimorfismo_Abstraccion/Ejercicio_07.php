<?php
interface Comunicable {
    public function enviarMensaje();
}

class Correo implements Comunicable {
    public function enviarMensaje() {
        echo "Enviando correo electrónico...\n";
    }
}

class Texto implements Comunicable {
    public function enviarMensaje() {
        echo "Enviando mensaje de texto...\n";
    }
}

$medios = [new Correo(), new Texto()];
foreach ($medios as $medio) {
    $medio->enviarMensaje();
}
?>
