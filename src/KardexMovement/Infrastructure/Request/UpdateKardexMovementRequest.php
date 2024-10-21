<?php

namespace Src\KardexMovement\Infrastructure\Request;

use App\Http\Requests\FormRequest;

class UpdateKardexMovementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'sometimes|required|in:in,out',
            'quantity' => 'sometimes|required|integer|min:1',
            'product_id' => 'required|exists:products,id'
        ];
    }
}
