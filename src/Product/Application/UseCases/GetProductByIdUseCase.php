<?php

namespace Src\Product\Application\UseCases;

use Src\Product\Domain\Repositories\ProductRepositoryInterface;

class GetProductByIdUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute($id)
    {
        return $this->productRepository->findById($id);
    }
}
