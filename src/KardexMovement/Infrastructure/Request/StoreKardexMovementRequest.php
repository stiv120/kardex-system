<?php

namespace Src\KardexMovement\Infrastructure\Request;

use App\Http\Requests\FormRequest;

class StoreKardexMovementRequest extends FormRequest
{
    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:in,out',
            'product_id' => 'required|integer|exists:products,id'
        ];
    }
}

