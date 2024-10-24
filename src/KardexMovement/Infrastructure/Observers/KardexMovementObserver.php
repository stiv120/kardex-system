<?php

namespace Src\KardexMovement\Infrastructure\Observers;

use App\Models\KardexMovement;
use Src\KardexMovement\Domain\Entities\MovementType;
use Src\Product\Application\UseCases\GetProductByIdUseCase;
use Src\Product\Application\UseCases\UpdateProductUseCase;

class KardexMovementObserver
{
    private $updateProductUseCase;
    private $getProductByIdUseCase;

    public function __construct(
        UpdateProductUseCase $updateProductUseCase,
        GetProductByIdUseCase $getProductByIdUseCase
    )
    {
        $this->updateProductUseCase = $updateProductUseCase;
        $this->getProductByIdUseCase = $getProductByIdUseCase;
    }

    /**
     * Handle the KardexMovement "created" event.
     */
    public function created(KardexMovement $kardexMovement): void
    {
        $this->validateUpdateStock($kardexMovement);
    }

    public function validateUpdateStock(KardexMovement $kardexMovement)
    {
        $quantity = $kardexMovement?->quantity;
        $type = MovementType::from($kardexMovement?->type);
        $product = $this->getProductByIdUseCase->execute($kardexMovement?->product_id);
        if ($type === MovementType::OUT) {
            // Decrease product stock
            $product->stock -= $quantity;
        } else {
            // Increase product stock
            $product->stock += $quantity;
        }
        return $this->updateProductUseCase->execute($product?->id, $product);
    }

    /**
     * Handle the KardexMovement "updated" event.
     */
    public function updated(KardexMovement $kardexMovement): void
    {
        $this->validateUpdateStock($kardexMovement);
    }

    /**
     * Handle the KardexMovement "deleted" event.
     */
    public function deleted(KardexMovement $kardexMovement): void
    {
        //
    }

    /**
     * Handle the KardexMovement "restored" event.
     */
    public function restored(KardexMovement $kardexMovement): void
    {
        //
    }

    /**
     * Handle the KardexMovement "force deleted" event.
     */
    public function forceDeleted(KardexMovement $kardexMovement): void
    {
        //
    }
}
