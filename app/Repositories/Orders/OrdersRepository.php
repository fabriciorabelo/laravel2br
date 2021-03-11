<?php

namespace App\Repositories\Orders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersRepository implements OrdersRepositoryInterface
{
    public function create(Request $request)
    {
        $data = $request->all();

        $order = Order::create([
            'user_id' => Auth::user()->id
        ]);

        foreach ($data['items'] as $item) {
            $product = Product::withTotalAmount()->findOrFail($item['product_id']);

            $orderProduct = new OrderProduct();
            $orderProduct->product()->associate($product);

            $orderProduct->price = (double) $item['price'];
            $orderProduct->amount = (double) $item['amount'];
            $orderProduct->discount_price = $orderProduct->price;

            if (($orderProduct->amount >= 5 && $orderProduct->amount <= 9) && $product->amount >= 500) {
                $orderProduct->discount = (double) $orderProduct->price * 0.15;
                $orderProduct->discount_price = (double) $orderProduct->price - $orderProduct->discount;
            }

            $order->orderProducts()->save($orderProduct);

            $orderProductStock = new ProductStock();
            $orderProductStock->product_id = $orderProduct->product_id;
            $orderProductStock->amount = - ($orderProduct->amount);
            $orderProductStock->order_product_id = $orderProduct->id;
            $orderProductStock->save();
        }

        return $order;
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->all();
        $order->update($data);

        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $product = Product::withTotalAmount()->findOrFail($item['product_id']);
                $orderProduct = OrderProduct::whereOrderId($order->id)
                    ->whereProductId($item['product_id'])
                    ->first();

                if (!$orderProduct) {
                    $orderProduct = new OrderProduct();
                }
                $orderProduct->product()->associate($product);

                $orderProduct->price = (double) $item['price'];
                $orderProduct->amount = (double) $item['amount'];
                $orderProduct->discount_price = $orderProduct->price;

                if (($orderProduct->amount >= 5 && $orderProduct->amount <= 9) && $product->amount >= 500) {
                    $orderProduct->discount = (double) $orderProduct->price * 0.15;
                    $orderProduct->discount_price = (double) $orderProduct->price - $orderProduct->discount;
                }
                $orderProduct->order_id = $order->id;
                $orderProduct->save();

                $orderProductStock = ProductStock::whereOrderProductId($orderProduct->id)->first();
                if (!$orderProductStock) {
                    $orderProductStock = new ProductStock();
                }
                $orderProductStock->product_id = $orderProduct->product_id;
                $orderProductStock->amount = - ($orderProduct->amount);
                $orderProductStock->order_product_id = $orderProduct->id;
                $orderProductStock->save();
            }
        }

        return $order;
    }
}
