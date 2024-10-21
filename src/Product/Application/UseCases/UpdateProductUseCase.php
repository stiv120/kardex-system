<?php

namespace Src\Product\Application\UseCases;

use Src\Product\Domain\Entities\Product;
use Src\Product\Domain\Repositories\ProductRepositoryInterface;

class UpdateProductUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute($id, $data)
    {
        $productRegistered = $this->productRepository->findById($id);
        $product = new Product(
            [
                'id' => $data?->id ?? $productRegistered?->id,
                'name' => $data?->name ?? $productRegistered?->name,
                'stock' => $data?->stock ?? $productRegistered?->stock,
                'unit_price' => $data?->unit_price ?? $productRegistered?->unit_price
            ]
        );
        return $this->productRepository->update($product);
    }
}
