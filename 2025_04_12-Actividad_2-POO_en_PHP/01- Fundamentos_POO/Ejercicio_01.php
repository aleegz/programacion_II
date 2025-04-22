<?php
class Libro {
    public $titulo;
    public $autor;
    
    public function informacionLibro() {
        echo "{$this->titulo}, de {$this->autor}.";
    }
}

$libro = new Libro();
$libro->titulo = "El código Da Vinci";
$libro->autor = "Dan Brown";
$libro->informacionLibro();
?>