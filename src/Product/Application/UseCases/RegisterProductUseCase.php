<?php

namespace Src\Product\Application\UseCases;

use Src\Product\Domain\Entities\Product;
use Src\Product\Domain\Repositories\ProductRepositoryInterface;

class RegisterProductUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(array $data)
    {
        $product = new Product($data);
        return $this->productRepository->save($product);
    }
}
