<?php

namespace Src\KardexMovement\Domain\Repositories;

use Src\KardexMovement\Domain\Entities\KardexMovement;

interface KardexMovementRepositoryInterface
{
    public function save(KardexMovement $kardexMovement);
    public function findAll();
    public function findById(int $id);
    public function update(KardexMovement $kardexMovement);
    public function delete(int $id);
}
