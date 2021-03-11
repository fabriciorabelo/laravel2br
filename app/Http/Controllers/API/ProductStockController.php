<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductStockResource;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductStockController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productStocks = ProductStock::all();
        return response([ 'productStocks' => ProductStockResource::collection($productStocks), 'message' => 'Retrieved successfully'], 200);
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
            'product_id' => 'required|max:20',
            'amount' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $productStock = ProductStock::create($data);

        return response(['productStock' => new ProductStockResource($productStock), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function show(ProductStock $productStock)
    {
        return response(['productStock' => new ProductStockResource($productStock), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductStock $productStock)
    {
        $productStock->update($request->all());

        return response(['productStock' => new ProductStockResource($productStock), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductStock $productStock)
    {
        $productStock->delete();

        return response(['message' => 'Deleted']);
    }
}
