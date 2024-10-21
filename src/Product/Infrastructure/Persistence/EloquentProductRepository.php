<?php

namespace Src\Product\Infrastructure\Persistence;

use Src\Product\Domain\Entities\Product;
use App\Models\Product as EloquentProduct;
use Src\Product\Domain\Repositories\ProductRepositoryInterface;

class EloquentProductRepository implements ProductRepositoryInterface
{
    /**
     * Save a new product to the database.
     * @param Product $product
     * @return bool
     */
    public function save(Product $product)
    {
        $eloquentProduct = new EloquentProduct();
        $eloquentProduct->name = $product->getName();
        $eloquentProduct->stock = $product->getStock();
        $eloquentProduct->unit_price = $product->getUnitPrice();
        return $eloquentProduct->save();
    }

    /**
     * Update an existing product in the database.
     * @param Product $product
     * @return bool
     */
    public function update(Product $product)
    {
        $eloquentProduct = $this->findById($product->getId());
        $eloquentProduct->name = $product->getName();
        $eloquentProduct->stock = $product->getStock();
        $eloquentProduct->unit_price = $product->getUnitPrice();
        return $eloquentProduct->save();
    }

    /**
     * Delete a product by its ID.
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        $eloquentProduct = $this->findById($id);
        return $eloquentProduct->delete();
    }

    /**
     * Retrieve all products from the database.
     * @return array
     */
    public function getAll()
    {
        return EloquentProduct::all()->toArray();
    }

    /**
     * Find a specific product by its ID.
     * @param int $id
     * @return EloquentProduct|null
     */
    public function findById($id)
    {
        return EloquentProduct::find($id);
    }
}



