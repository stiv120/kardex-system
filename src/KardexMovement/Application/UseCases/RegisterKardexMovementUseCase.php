<?php

namespace Src\KardexMovement\Application\UseCases;

use Src\KardexMovement\Domain\Entities\KardexMovement;
use Src\KardexMovement\Domain\Repositories\KardexMovementRepositoryInterface;

class RegisterKardexMovementUseCase
{
    private $kardexMovementRepository;

    public function __construct(KardexMovementRepositoryInterface $kardexMovementRepository)
    {
        $this->kardexMovementRepository = $kardexMovementRepository;
    }

    public function execute(array $data)
    {
        $kardexMovement = new KardexMovement($data);
        return $this->kardexMovementRepository->save($kardexMovement);
    }
}
