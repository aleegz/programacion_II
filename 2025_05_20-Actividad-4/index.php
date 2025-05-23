<?php
require 'autoload.php';

use App\Controllers\ControladorUsuario;
use Utils\Matematica;
use Providers\Tools\Ayudante as AyudaProveedor;
use App\Views\Vista;
use App\Models\Empleado;
use Config\ConfiguracionApp;
use function App\Helpers\saludar;

echo "--- ControladorUsuario ---\n";
$ctrl = new ControladorUsuario();
echo $ctrl->Inicio() . "\n";

echo "--- Matematica ---\n";
echo Matematica::sumar(4, 6) . "\n";

echo "--- Ayudante ---\n";
echo AyudaProveedor::ayudar() . "\n";

echo "--- Vista ---\n";
$vista = new Vista();
echo $vista->renderizar() . "\n";

echo "--- Empleado ---\n";
$empleado = new Empleado();
echo $empleado->saludar() . " y " . $empleado->trabajar() . "\n";

echo "--- Configuracion ---\n";
echo ConfiguracionApp::NOMBRE_APP . "\n";

echo "--- Funcion ayudante ---\n";
echo saludar() . "\n";
