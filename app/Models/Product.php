<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
        'amount' => 'double',
    ];

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function scopeWithTotalAmount($query)
    {
        return $query->selectRaw('products.*, COALESCE((SELECT SUM(amount) FROM product_stocks WHERE product_stocks.product_id = products.id), 0) AS amount');
    }
}
