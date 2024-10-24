<?php

namespace Src\KardexMovement\Application\UseCases;

use App\Exceptions\CustomJsonException;
use Src\KardexMovement\Domain\Entities\MovementType;
use Src\Product\Application\UseCases\GetProductByIdUseCase;

class ValidateProductStockUseCase
{
    private $getProductByIdUseCase;

    public function __construct(
        GetProductByIdUseCase $getProductByIdUseCase,
    )
    {
        $this->getProductByIdUseCase = $getProductByIdUseCase;
    }

    public function execute($datos)
    {
        $quantity = $datos?->quantity;
        $type = MovementType::from($datos?->type);
        $product = $this->getProductByIdUseCase->execute($datos?->product_id);

        if ($type === MovementType::OUT && $product?->stock < $quantity) {
            // Ensure sufficient stock for 'out' movement
            throw new CustomJsonException([
                "message" => "Insufficient stock for product {$product?->name}, only {$product?->stock} left in stock.",
                "code" => 422
            ]);
        }
        return true;
    }
}
