<?php

namespace Src\Product\Domain\Repositories;

use Src\Product\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product);
    public function update(Product $product);
    public function delete($id);
    public function getAll();
    public function findById($id);
}


