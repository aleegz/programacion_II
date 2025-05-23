<?php
namespace App\Models;

use App\Base\Persona;

class Empleado extends Persona {
    public function trabajar() {
        return "Trabajando";
    }
}
