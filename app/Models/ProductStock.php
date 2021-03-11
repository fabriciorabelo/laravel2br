<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'amount',
        'order_product_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'double',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }
}
