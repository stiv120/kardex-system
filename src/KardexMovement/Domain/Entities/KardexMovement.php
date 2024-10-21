<?php

namespace Src\KardexMovement\Domain\Entities;

class KardexMovement
{
    private $id;
    private $productId;
    private $type;
    private $quantity;
    private $totalPrice;

    public function __construct($data)
    {
        $this->type = $data['type'];
        $this->id = $data['id'] ?? null;
        $this->quantity = $data['quantity'];
        $this->productId = $data['product_id'];
        $this->totalPrice = $data['total_price'] ?? null;
    }

    public function getId() {
        return $this->id;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function getType() {
        return $this->type;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }
}
