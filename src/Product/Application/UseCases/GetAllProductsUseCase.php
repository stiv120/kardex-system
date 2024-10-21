<?php

namespace Src\Product\Application\UseCases;

use Src\Product\Domain\Repositories\ProductRepositoryInterface;

class GetAllProductsUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute()
    {
        return $this->productRepository->getAll();
    }
}

