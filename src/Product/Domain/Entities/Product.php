<?php

namespace Src\Product\Domain\Entities;

class Product
{
    private $id;
    private $name;
    private $stock;
    private $unitPrice;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->stock = $data['stock'];
        $this->unitPrice = $data['unit_price'];
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getUnitPrice() {
        return $this->unitPrice;
    }
}
