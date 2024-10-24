<?php

namespace Src\Product\Infrastructure\Request;

use App\Http\Requests\FormRequest;
use Src\Product\Application\UseCases\GetProductByIdUseCase;

class UpdateProductRequest extends FormRequest
{
    private $getProductByIdUseCase;

    public function __construct(
        GetProductByIdUseCase $getProductByIdUseCase
    ) {
        $this->getProductByIdUseCase = $getProductByIdUseCase;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'stock' => 'sometimes|required|numeric|min:0',
            'unit_price' => 'sometimes|required|numeric|min:0'
        ];
    }

    /**
     * Prepare the data for validation.
     * @return void
     */
    protected function passedValidation()
    {
        $this->productExists();
    }

    /**
     * Check if a product exists by ID.
     * @return void
     */
    public function productExists()
    {
        $productExists = $this->getProductByIdUseCase->execute($this->product);
        if (!$productExists) {
            $this->failedValidation(['Product not found!']);
        }
    }
}
