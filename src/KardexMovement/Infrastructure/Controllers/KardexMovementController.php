<?php

namespace Src\KardexMovement\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\Product\Application\UseCases\UpdateProductUseCase;
use Src\Product\Application\UseCases\GetProductByIdUseCase;
use Src\KardexMovement\Application\UseCases\GetAllKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\UpdateKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\DeleteKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\GetKardexMovementByIdUseCase;
use Src\KardexMovement\Infrastructure\Request\StoreKardexMovementRequest;
use Src\KardexMovement\Infrastructure\Request\UpdateKardexMovementRequest;
use Src\KardexMovement\Application\UseCases\RegisterKardexMovementUseCase;

class KardexMovementController extends Controller
{
    private $registerKardexMovementUseCase;
    private $getAllKardexMovementUseCase;
    private $getKardexMovementByIdUseCase;
    private $updateKardexMovementUseCase;
    private $deleteKardexMovementUseCase;
    private $getProductByIdUseCase;
    private $updateProductUseCase;

    public function __construct(
        RegisterKardexMovementUseCase $registerKardexMovementUseCase,
        GetAllKardexMovementUseCase $getAllKardexMovementUseCase,
        GetKardexMovementByIdUseCase $getKardexMovementByIdUseCase,
        UpdateKardexMovementUseCase $updateKardexMovementUseCase,
        DeleteKardexMovementUseCase $deleteKardexMovementUseCase,
        GetProductByIdUseCase $getProductByIdUseCase,
        UpdateProductUseCase $updateProductUseCase,
    ) {
        $this->registerKardexMovementUseCase = $registerKardexMovementUseCase;
        $this->getAllKardexMovementUseCase = $getAllKardexMovementUseCase;
        $this->getKardexMovementByIdUseCase = $getKardexMovementByIdUseCase;
        $this->updateKardexMovementUseCase = $updateKardexMovementUseCase;
        $this->deleteKardexMovementUseCase = $deleteKardexMovementUseCase;
        $this->getProductByIdUseCase = $getProductByIdUseCase;
        $this->updateProductUseCase = $updateProductUseCase;
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreKardexMovementRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if there is an error during the product creation process.
     */
    public function store(StoreKardexMovementRequest $request)
    {
        $this->validateUpdateStock($request);
        $request['total_price'] = $this->getTotalPrice($request->input('product_id'), $request->input('quantity'));
        $storeKardexMovement = $this->registerKardexMovementUseCase->execute($request->all());
        if (!$storeKardexMovement) {
            throw new CustomJsonException(['message' => 'Error creating kardex movement.',  'code' => 500]);
        }
        return response()->json(['message' => 'Kardex movement registered successfully.'], 201);
    }

    /**
     * Validate and update the stock based on the kardex movement type (in/out).
     * @param \Illuminate\Http\Request $request
     * @throws CustomJsonException if there is insufficient stock for an 'out' movement.
     */
    public function validateUpdateStock($request)
    {
        $type = $request->input('type');
        $quantity = $request->input('quantity');
        $product = $this->getProductByIdUseCase->execute($request->input('product_id'));

        // Check if the movement type is 'in' (entry) or 'out' (exit)
        if ($type === 'in') {
            // Increase product stock
            $product->stock += $quantity;
        } elseif ($type === 'out') {
            // Ensure sufficient stock for 'out' movement
            if ($product?->stock >= $quantity) {
                // Decrease product stock
                $product->stock -= $quantity;
            } else {
                throw new CustomJsonException([
                    "message" => "Insufficient stock for product {$product?->name}, only {$product?->stock} left in stock.",
                    "code" => 422
                ]);
            }
        }

        // Update the product stock in the database
        return $this->updateProductUseCase->execute($product?->id, $product);
    }

    /**
     * Calculate the total price for a kardex movement.
     * @param int $productId
     * @param int $quantity
     * @return float
     */
    public function getTotalPrice($productId, $quantity)
    {
        // Retrieve the product's unit price and multiply by the quantity
        return $this->getProductByIdUseCase->execute($productId)?->unit_price * $quantity;
    }

        /**
     * Display a listing of the kardex movements.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $movements = $this->getAllKardexMovementUseCase->execute();
        return response()->json($movements);
    }

    /**
     * Display the specified kardex movement by ID.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if the kardex movement is not found.
     */
    public function show($id)
    {
        $movement = $this->getKardexMovementByIdUseCase->execute($id);
        if (!$movement) {
            throw new CustomJsonException(['status' => 'info', 'message' => 'Kardex movement not found!', 'code' => 404]);
        }
        return response()->json($movement);
    }

    /**
     * Update the specified kardex movement by ID.
     * @param UpdateKardexMovementRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if the kardex movement cannot be updated.
     */
    public function update(UpdateKardexMovementRequest $request, $id)
    {
        $this->kardexMovementExists($id);
        $this->validateUpdateStock($request);
        $request['total_price'] = $this->getTotalPrice($request->input('product_id'), $request->input('quantity'));
        $updatedKardexMovement = $this->updateKardexMovementUseCase->execute($id, (object) $request->all());
        if (!$updatedKardexMovement) {
            throw new CustomJsonException(['message' => 'Error updating kardex movement.', 'code' => 500]);
        }
        return response()->json(['message' => 'Kardex movement updated successfully.']);
    }

    /**
     * Check if a kardex movement exists by ID.
     * @param int $id
     * @throws CustomJsonException if the kardex movement is not found.
     */
    public function kardexMovementExists($id)
    {
        $kardexMovementExists = $this->getKardexMovementByIdUseCase->execute($id);
        if (!$kardexMovementExists) {
            throw new CustomJsonException(['status' => 'info','message' => 'Kardex movement not found!', 'code' => 404]);
        }
    }

    /**
     * Remove the specified kardex movement by ID.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if the kardex movement cannot be deleted.
     */
    public function destroy($id)
    {
        $deletedKardexMovement = $this->deleteKardexMovementUseCase->execute($id);
        if (!$deletedKardexMovement) {
            throw new CustomJsonException(['message' => 'Error deleting kardex movement.', 'code' => 500]);
        }
        return response()->json(['message' => 'Kardex movement deleted successfully.']);
    }
}

