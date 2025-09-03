<?php
class Estudiante {
    private $calificaciones;

    public function __construct() {
        $this->calificaciones = [];
    }

    public function agregarCalificacion($nota) {
        if ($nota >= 0 && $nota <= 10) {
            $this->calificaciones[] = $nota;
        } else {
            echo "Error: La calificación debe estar entre 0 y 10.\n";
        }
    }

    public function getPromedio() {
        if (count($this->calificaciones) === 0) {
            return 0;
        }
        return array_sum($this->calificaciones) / count($this->calificaciones);
    }
}

$estudiante = new Estudiante();
$estudiante->agregarCalificacion(8);
$estudiante->agregarCalificacion(9);
$estudiante->agregarCalificacion(11); // Error
echo "Promedio: " . $estudiante->getPromedio() . "\n";
?>
