<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'orderProductId' => $this->id,
            'discount' => (double) number_format($this->discount, 2, '.', ''),
            'priceWithoutDiscount' => (double) number_format($this->price, 2, '.', ''),
            'priceWithDiscount' => (double) number_format($this->discount_price, 2, '.', ''),
            'totalAmount' => (double) $this->amount,
            'totalDiscount' => (double) number_format($this->discount * $this->amount, 2, '.', ''),
            'totalPriceWithoutDiscount' => (double) number_format($this->price * $this->amount, 2, '.', ''),
            'totalPriceWithDiscount' => (double) number_format($this->discount_price * $this->amount, 2, '.', ''),
            'product' => new ProductResource($this->product),
        ];
    }
}
