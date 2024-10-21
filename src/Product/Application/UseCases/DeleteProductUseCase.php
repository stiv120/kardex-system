<?php

namespace Src\Product\Application\UseCases;

use Src\Product\Domain\Repositories\ProductRepositoryInterface;

class DeleteProductUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute($id)
    {
        return $this->productRepository->delete($id);
    }
}
