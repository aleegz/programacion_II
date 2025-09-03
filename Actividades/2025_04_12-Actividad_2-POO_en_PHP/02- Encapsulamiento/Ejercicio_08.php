<?php
class Empleado {
    private $sueldo;

    public function __construct($sueldo) {
        $this->sueldo = $sueldo;
    }

    public function getSueldo() {
        return $this->sueldo;
    }

    public function aumentarSueldo($porcentaje) {
        if ($porcentaje > 0) {
            $this->sueldo += $this->sueldo * ($porcentaje / 100);
        }
    }
}

$empleado = new Empleado(3000);
$empleado->aumentarSueldo(10);
echo "Sueldo aumentado: " . $empleado->getSueldo() . "\n";
?>
