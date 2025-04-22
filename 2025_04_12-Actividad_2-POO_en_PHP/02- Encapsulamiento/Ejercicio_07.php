<?php
class Libro {
    private $numeroPaginas;

    public function __construct($numeroPaginas) {
        $this->setPaginas($numeroPaginas);
    }

    public function getPaginas() {
        return $this->numeroPaginas;
    }

    public function setPaginas($paginas) {
        if ($paginas > 0) {
            $this->numeroPaginas = $paginas;
        } else {
            echo "Error: El número de páginas debe ser mayor a 0.\n";
        }
    }
}

$libro = new Libro(150);
echo "Número de páginas: " . $libro->getPaginas() . "\n";

$libro->setPaginas(0); // Error
?>
