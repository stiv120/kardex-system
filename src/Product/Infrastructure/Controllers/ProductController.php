<?php

namespace Src\Product\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\Product\Application\UseCases\DeleteProductUseCase;
use Src\Product\Application\UseCases\UpdateProductUseCase;
use Src\Product\Application\UseCases\GetAllProductsUseCase;
use Src\Product\Application\UseCases\GetProductByIdUseCase;
use Src\Product\Infrastructure\Request\StoreProductRequest;
use Src\Product\Application\UseCases\RegisterProductUseCase;
use Src\Product\Infrastructure\Request\UpdateProductRequest;

class ProductController extends Controller
{
    private $registerProductUseCase;
    private $getAllProductsUseCase;
    private $getProductByIdUseCase;
    private $updateProductUseCase;
    private $deleteProductUseCase;

    public function __construct(
        RegisterProductUseCase $registerProductUseCase,
        GetAllProductsUseCase $getAllProductsUseCase,
        GetProductByIdUseCase $getProductByIdUseCase,
        UpdateProductUseCase $updateProductUseCase,
        DeleteProductUseCase $deleteProductUseCase
    ) {
        $this->registerProductUseCase = $registerProductUseCase;
        $this->getAllProductsUseCase = $getAllProductsUseCase;
        $this->getProductByIdUseCase = $getProductByIdUseCase;
        $this->updateProductUseCase = $updateProductUseCase;
        $this->deleteProductUseCase = $deleteProductUseCase;
    }

    /**
     * Store a newly created product in storage.
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if there is an error during the product creation process.
     */
    public function store(StoreProductRequest $request)
    {
        $storeProduct = $this->registerProductUseCase->execute($request->all());
        if (!$storeProduct) {
            throw new CustomJsonException(['message' => 'Error creating product.']);
        }
        return response()->json(['message' => 'Product created successfully.'], 201);
    }

    /**
     * Retrieve and display a listing of all products.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = $this->getAllProductsUseCase->execute();
        return response()->json($products);
    }

    /**
     * Display the specified product.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if the product is not found.
     */
    public function show($id)
    {
        $product = $this->getProductByIdUseCase->execute($id);
        if (!$product) {
            throw new CustomJsonException(['status' => 'info', 'message' => 'Product not found!', 'code' => 404]);
        }
        return response()->json($product);
    }

    /**
     * Update the specified product in storage.
     * @param UpdateProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if the product is not found or the update fails.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $updatedProduct = $this->updateProductUseCase->execute($id, (object) $request->all());
        if (!$updatedProduct) {
            throw new CustomJsonException(['message' => 'Error updating product.']);
        }
        return response()->json(['message' => 'Product updated successfully.']);
    }

    /**
     * Remove the specified product from storage.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if the product is not found or the deletion fails.
     */
    public function destroy($id)
    {
        $deletedProduct = $this->deleteProductUseCase->execute($id);
        if (!$deletedProduct) {
            throw new CustomJsonException(['message' => 'Error deleting product.']);
        }
        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
