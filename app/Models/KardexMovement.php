<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KardexMovement extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'quantity', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
