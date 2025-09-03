<?php
class Cuenta {
    public $saldo = 0;

    public function ingresar($monto) {
        if ($monto > 0) {
            $this->saldo += $monto;
        }
    }

    public function retirar($monto) {
        if ($monto > 0 && $monto <= $this->saldo) {
            $this->saldo -= $monto;
        }
    }
}

$cuenta = new Cuenta();
$cuenta->ingresar(1000);
$cuenta->retirar(300);

echo "Saldo final: {$cuenta->saldo}\n";
?>
