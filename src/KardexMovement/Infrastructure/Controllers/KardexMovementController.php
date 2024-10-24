<?php

namespace Src\KardexMovement\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\KardexMovement\Application\UseCases\GetAllKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\UpdateKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\DeleteKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\GetKardexMovementByIdUseCase;
use Src\KardexMovement\Infrastructure\Request\StoreKardexMovementRequest;
use Src\KardexMovement\Infrastructure\Request\UpdateKardexMovementRequest;
use Src\KardexMovement\Application\UseCases\RegisterKardexMovementUseCase;

class KardexMovementController extends Controller
{
    private $getAllKardexMovementUseCase;
    private $updateKardexMovementUseCase;
    private $deleteKardexMovementUseCase;
    private $getKardexMovementByIdUseCase;
    private $registerKardexMovementUseCase;

    public function __construct(
        GetAllKardexMovementUseCase $getAllKardexMovementUseCase,
        UpdateKardexMovementUseCase $updateKardexMovementUseCase,
        DeleteKardexMovementUseCase $deleteKardexMovementUseCase,
        GetKardexMovementByIdUseCase $getKardexMovementByIdUseCase,
        RegisterKardexMovementUseCase $registerKardexMovementUseCase
    ) {
        $this->getAllKardexMovementUseCase = $getAllKardexMovementUseCase;
        $this->updateKardexMovementUseCase = $updateKardexMovementUseCase;
        $this->deleteKardexMovementUseCase = $deleteKardexMovementUseCase;
        $this->getKardexMovementByIdUseCase = $getKardexMovementByIdUseCase;
        $this->registerKardexMovementUseCase = $registerKardexMovementUseCase;
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreKardexMovementRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException if there is an error during the product creation process.
     */
    public function store(StoreKardexMovementRequest $request)
    {
        $storeKardexMovement = $this->registerKardexMovementUseCase->execute($request->all());
        if (!$storeKardexMovement) {
            throw new CustomJsonException(['message' => 'Error creating kardex movement.']);
        }
        return response()->json(['message' => 'Kardex movement registered successfully.'], 201);
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
        $updatedKardexMovement = $this->updateKardexMovementUseCase->execute($id, (object) $request->all());
        if (!$updatedKardexMovement) {
            throw new CustomJsonException(['message' => 'Error updating kardex movement.']);
        }
        return response()->json(['message' => 'Kardex movement updated successfully.']);
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
            throw new CustomJsonException(['message' => 'Error deleting kardex movement.']);
        }
        return response()->json(['message' => 'Kardex movement deleted successfully.']);
    }
}

