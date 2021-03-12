<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class OrderResource extends JsonResource
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
            'orderId' => $this->id,
            'orderCode' => $this->created_at->format('YmdHi-') . $this->id,
            'orderDate' => $this->created_at,
            'totalAmount' => (double) $this->orderProducts()->sum('amount'),
            'totalAmountWihtoutDiscount' =>  (double) number_format($this->orderProducts()->sum(DB::raw('(price * amount)')), 2, '.', ''),
            'totalAmountWithDiscount' =>  (double) number_format($this->orderProducts()->sum(DB::raw('(discount_price * amount)')), 2, '.', ''),
            'items' => OrderProductResource::collection($this->orderProducts),
            'user' => new UserResource($this->user),
        ];
    }
}
