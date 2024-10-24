<?php

namespace Src\Product\Application\UseCases;

use App\Exceptions\CustomJsonException;
use Src\Product\Domain\Repositories\ProductRepositoryInterface;

class DeleteProductUseCase
{
    private $productRepository;
    private $getProductByIdUseCase;

    public function __construct(
        GetProductByIdUseCase $getProductByIdUseCase,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->getProductByIdUseCase = $getProductByIdUseCase;
    }

    public function execute($id)
    {
        $productExists = $this->getProductByIdUseCase->execute($id);
        if (!$productExists) {
            throw new CustomJsonException(['status' => 'info', 'message' => 'Product not found!', 'code' => 404]);
        }
        return $this->productRepository->delete($id);
    }
}
