<?php

namespace Src\KardexMovement\Application\UseCases;

use Src\Product\Application\UseCases\GetProductByIdUseCase;

class GetTotalPriceUseCase
{
    private $getProductByIdUseCase;

    public function __construct(
        GetProductByIdUseCase $getProductByIdUseCase,
    )
    {
        $this->getProductByIdUseCase = $getProductByIdUseCase;
    }

    public function execute($productId, $quantity)
    {
        return $this->getProductByIdUseCase->execute($productId)?->unit_price * $quantity;
    }
}
