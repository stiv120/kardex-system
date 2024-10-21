<?php

namespace Src\KardexMovement\Application\UseCases;

use Src\KardexMovement\Domain\Repositories\KardexMovementRepositoryInterface;

class GetAllKardexMovementUseCase
{
    private $kardexMovementRepository;

    public function __construct(KardexMovementRepositoryInterface $kardexMovementRepository)
    {
        $this->kardexMovementRepository = $kardexMovementRepository;
    }

    public function execute()
    {
        return $this->kardexMovementRepository->findAll();
    }
}


