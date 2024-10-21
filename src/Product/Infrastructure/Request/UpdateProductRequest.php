<?php

namespace Src\Product\Infrastructure\Request;

use App\Http\Requests\FormRequest;

class UpdateProductRequest extends FormRequest
{
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
            'unit_price' => 'sometimes|required|numeric|min:0',
        ];
    }
}
