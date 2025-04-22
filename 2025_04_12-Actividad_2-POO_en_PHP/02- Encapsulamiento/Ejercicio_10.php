<?php
class CuentaCorriente {
    private $saldo;
    private $limite;

    public function __construct($saldo, $limite) {
        $this->saldo = $saldo;
        $this->limite = $limite;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function retirar($monto) {
        if ($monto > 0 && $monto <= $this->saldo + $this->limite) {
            $this->saldo -= $monto;
        } else {
            echo "Error: No hay suficiente saldo y límite para retirar esa cantidad.\n";
        }
    }
}

$cuenta = new CuentaCorriente(500, 200);
$cuenta->retirar(600);
echo "Saldo después del retiro: " . $cuenta->getSaldo() . "\n";

$cuenta->retirar(200); // Error
?>
