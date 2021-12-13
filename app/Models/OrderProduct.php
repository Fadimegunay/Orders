<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'unitPrice',
        'totalPrice'
    ];

    public function product() 
    {
        return $this->belongsTo(Product::class, 'productId', 'id');
    }
}
