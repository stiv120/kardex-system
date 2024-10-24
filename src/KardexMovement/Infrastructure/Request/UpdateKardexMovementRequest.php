<?php

namespace Src\KardexMovement\Infrastructure\Request;

use App\Http\Requests\FormRequest;
use Src\KardexMovement\Application\UseCases\GetTotalPriceUseCase;
use Src\KardexMovement\Application\UseCases\ValidateProductStockUseCase;
use Src\KardexMovement\Application\UseCases\GetKardexMovementByIdUseCase;

class UpdateKardexMovementRequest extends FormRequest
{
    private $getTotalPriceUseCase;
    private $validateProductStockUseCase;
    private $getKardexMovementByIdUseCase;

    public function __construct(
        GetTotalPriceUseCase $getTotalPriceUseCase,
        ValidateProductStockUseCase $validateProductStockUseCase,
        GetKardexMovementByIdUseCase $getKardexMovementByIdUseCase
    ) {
        $this->getTotalPriceUseCase = $getTotalPriceUseCase;
        $this->validateProductStockUseCase = $validateProductStockUseCase;
        $this->getKardexMovementByIdUseCase = $getKardexMovementByIdUseCase;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'sometimes|required|in:in,out',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1'
        ];
    }

    /**
     * Prepare the data for validation.
     * @return void
     */
    protected function passedValidation()
    {
        $this->kardexMovementExists();
        $totalPrice = $this->getTotalPriceUseCase->execute($this->product_id, $this->quantity);
        $this->merge(['total_price' => $totalPrice]);
        $this->validateProductStockUseCase->execute($this);
    }

    /**
     * Check if a kardex movement exists by ID.
     * @return void
     */
    public function kardexMovementExists()
    {
        $kardexMovementExists = $this->getKardexMovementByIdUseCase->execute($this->kardex_movement);
        if (!$kardexMovementExists) {
            $this->failedValidation(['Kardex movement not found!']);
        }
    }
}
