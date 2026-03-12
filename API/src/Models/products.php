<?php
namespace Models;

class Product {
    public int $id;
    public string $description;
    public string $stock;

    public function __construct(int $id = null, string $description, string $stock)
    {
        $this->id = $id;
        $this->description = $description;
        $this->stock = $stock;
    }
}
