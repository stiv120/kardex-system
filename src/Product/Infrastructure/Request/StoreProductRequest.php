<?php

namespace Src\Product\Infrastructure\Request;

use App\Http\Requests\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0'
        ];
    }
}
