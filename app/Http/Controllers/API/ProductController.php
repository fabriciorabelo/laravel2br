<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::withTotalAmount()->get();
        return response([ 'products' => ProductResource::collection($products), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:191',
            'sku' => 'required|max:18',
            'description' => 'max:255',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $product = Product::create($data);
        if (isset($data["amount"])) {
            $productStock = new ProductStock();
            $productStock->fill(['amount' => $data["amount"]]);

            $product->productStocks()->save($productStock);
        }

        return response(['product' => new ProductResource($product), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response(['product' => new ProductResource($product), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $product->update($data);

        if (isset($data["amount"])) {
            $productStock = new ProductStock();
            $productStock->fill(['amount' => $data["amount"]]);

            $product->productStocks()->save($productStock);
        }

        return response(['product' => new ProductResource($product), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response(['message' => 'Deleted']);
    }
}
