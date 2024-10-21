<?php

namespace Src\KardexMovement\Infrastructure\Persistence;

use App\Models\KardexMovement as KardexMovementModel;
use Src\KardexMovement\Domain\Entities\KardexMovement;
use Src\KardexMovement\Domain\Repositories\KardexMovementRepositoryInterface;

class EloquentKardexMovementRepository implements KardexMovementRepositoryInterface
{
    /**
     * Save a new Kardex movement record to the database.
     * @param KardexMovement $kardexMovement
     * @return bool
     */
    public function save(KardexMovement $kardexMovement)
    {
        $model = new KardexMovementModel();
        $model->type = $kardexMovement->getType();
        $model->quantity = $kardexMovement->getQuantity();
        $model->product_id = $kardexMovement->getProductId();
        $model->total_price = $kardexMovement->getTotalPrice();
        return $model->save();
    }

    /**
     * Retrieve all Kardex movement records from the database.
     * @return array
     */
    public function findAll(): array
    {
        return KardexMovementModel::with('product')
            ->get()
            ->toArray();
    }

    /**
     * Find a specific Kardex movement by its ID.
     * @param int $id
     * @return KardexMovementModel|null
     */
    public function findById(int $id)
    {
        return KardexMovementModel::with('product')->find($id);
    }

    /**
     * Update an existing Kardex movement record in the database.
     * @param KardexMovement $kardexMovement
     * @return bool
     */
    public function update(KardexMovement $kardexMovement)
    {
        $model = KardexMovementModel::find($kardexMovement->getId());
        $model->quantity = $kardexMovement->getQuantity();
        $model->type = $kardexMovement->getType();
        $model->product_id = $kardexMovement->getProductId();
        $model->total_price = $kardexMovement->getTotalPrice();
        return $model->save();
    }

    /**
     * Delete a specific Kardex movement record by its ID.
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id)
    {
        $eloquentKardexMovement = $this->findById($id);
        return $eloquentKardexMovement->delete();
    }
}
