<?php

namespace App\Repositories\Orders;

use App\Models\Order;
use Illuminate\Http\Request;

interface OrdersRepositoryInterface
{
    public function create(Request $request);

    public function update(Request $request, Order $model);
}
