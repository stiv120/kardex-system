<?php

namespace Src\KardexMovement\Application\UseCases;

use App\Exceptions\CustomJsonException;
use Src\KardexMovement\Domain\Repositories\KardexMovementRepositoryInterface;

class DeleteKardexMovementUseCase
{
    private $kardexMovementRepository;
    private $getKardexMovementByIdUseCase;

    public function __construct(
        GetKardexMovementByIdUseCase $getKardexMovementByIdUseCase,
        KardexMovementRepositoryInterface $kardexMovementRepository
    )
    {
        $this->kardexMovementRepository = $kardexMovementRepository;
        $this->getKardexMovementByIdUseCase = $getKardexMovementByIdUseCase;
    }

    public function execute(int $id)
    {
        $movement = $this->getKardexMovementByIdUseCase->execute($id);
        if (!$movement) {
            throw new CustomJsonException(['status' => 'info', 'message' => 'Kardex movement not found!', 'code' => 404]);
        }
        return $this->kardexMovementRepository->delete($id);
    }
}

