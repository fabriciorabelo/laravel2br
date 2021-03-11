<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductStockResource extends JsonResource
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
            'productStockId' => $this->id,
            'createDate' => $this->created_at,
            'updatedDate' => $this->updated_at,
            'amount' => $this->amount,
            'product' =>  new ProductResource($this->product),
        ];
    }
}
