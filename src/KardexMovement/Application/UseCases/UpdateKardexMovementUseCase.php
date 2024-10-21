<?php

namespace Src\KardexMovement\Application\UseCases;

use Src\KardexMovement\Domain\Entities\KardexMovement;
use Src\KardexMovement\Domain\Repositories\KardexMovementRepositoryInterface;

class UpdateKardexMovementUseCase
{
    private $kardexMovementRepository;

    public function __construct(KardexMovementRepositoryInterface $kardexMovementRepository)
    {
        $this->kardexMovementRepository = $kardexMovementRepository;
    }

    public function execute($id, $data)
    {
        $kardexMovementRegistered = $this->kardexMovementRepository->findById($id);
        $kardexMovement = new KardexMovement(
            [
                'id' => $data?->id ?? $kardexMovementRegistered?->id,
                'type' => $data?->type ?? $kardexMovementRegistered?->type,
                'quantity' => $data?->quantity ?? $kardexMovementRegistered?->quantity,
                'product_id' => $data?->product_id ?? $kardexMovementRegistered?->product_id,
                'total_price' => $data?->total_price ?? $kardexMovementRegistered?->total_price
            ]
        );
        return $this->kardexMovementRepository->update($kardexMovement);
    }
}

