<?php
namespace App\Views;

use Interfaces\Renderable;

class Vista implements Renderable {
    public function renderizar() {
        return "Renderizando vista";
    }
}
