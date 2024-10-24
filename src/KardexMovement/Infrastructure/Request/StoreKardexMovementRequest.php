<?php

namespace Src\KardexMovement\Infrastructure\Request;

use App\Http\Requests\FormRequest;
use Src\KardexMovement\Application\UseCases\GetTotalPriceUseCase;
use Src\KardexMovement\Application\UseCases\ValidateProductStockUseCase;

class StoreKardexMovementRequest extends FormRequest
{
    private $getTotalPriceUseCase;
    private $validateProductStockUseCase;

    public function __construct(
        GetTotalPriceUseCase $getTotalPriceUseCase,
        ValidateProductStockUseCase $validateProductStockUseCase
    ) {
        $this->getTotalPriceUseCase = $getTotalPriceUseCase;
        $this->validateProductStockUseCase = $validateProductStockUseCase;
    }

    public function rules()
    {
        return [
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|integer|exists:products,id'
        ];
    }

    /**
     * Prepare the data for validation.
     * @return void
     */
    protected function passedValidation()
    {
        $totalPrice = $this->getTotalPriceUseCase->execute($this->product_id, $this->quantity);
        $this->merge(['total_price' => $totalPrice]);
        $this->validateProductStockUseCase->execute($this);
    }
}

