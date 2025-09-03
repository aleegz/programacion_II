<?php
class Cuenta {
    protected $saldo;

    public function __construct($saldo = 0) {
        $this->saldo = $saldo;
    }

    public function depositar($monto) {
        if ($monto > 0) {
            $this->saldo += $monto;
        }
    }

    public function retirar($monto) {
        if ($monto > 0 && $monto <= $this->saldo) {
            $this->saldo -= $monto;
        }
    }

    public function getSaldo() {
        return $this->saldo;
    }
}

class CuentaPremium extends Cuenta {
    public $bonificacion;

    public function __construct($saldo = 0, $bonificacion = 0) {
        parent::__construct($saldo);
        $this->bonificacion = $bonificacion;
    }

    public function aplicarBonificacion() {
        if ($this->bonificacion > 0) {
            $this->saldo += $this->saldo * ($this->bonificacion / 100);
        }
    }
}

$cuenta = new CuentaPremium(1000, 5);
$cuenta->aplicarBonificacion();
echo "Saldo tras bonificación: " . $cuenta->getSaldo() . "\n";
?>
