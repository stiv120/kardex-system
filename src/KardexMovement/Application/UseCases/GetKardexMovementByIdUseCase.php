<?php

namespace Src\KardexMovement\Application\UseCases;

use Src\KardexMovement\Domain\Repositories\KardexMovementRepositoryInterface;

class GetKardexMovementByIdUseCase
{
    private $kardexMovementRepository;

    public function __construct(KardexMovementRepositoryInterface $kardexMovementRepository)
    {
        $this->kardexMovementRepository = $kardexMovementRepository;
    }

    public function execute(int $id)
    {
        return $this->kardexMovementRepository->findById($id);
    }
}
