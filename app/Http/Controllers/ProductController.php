<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Product::with(['make', 'category', 'productType', 'store', 'registeredBy'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'make_id' => 'required|exists:makes,id',
            'category_id' => 'required|exists:categories,id',
            'product_type_id' => 'required|exists:product_types,id',
            'store_id' => 'required|exists:stores,id',
            'user_id' => 'required|exists:users,id',
            'condition' => 'required|in:New,Good,Damaged',
            'total_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0|lte:total_stock',
            'description' => 'nullable|string',
            'status' => 'required|integer|in:0,1',
        ]);

        return Product::create($validated);
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product->load(['make', 'category', 'productType', 'store', 'registeredBy']));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'string',
            'make_id' => 'exists:makes,id',
            'category_id' => 'exists:categories,id',
            'product_type_id' => 'exists:product_types,id',
            'store_id' => 'exists:stores,id',
            'user_id' => 'exists:users,id',
            'condition' => 'in:New,Good,Damaged',
            'total_stock' => 'integer|min:0',
            'current_stock' => 'integer|min:0|lte:total_stock',
            'description' => 'nullable|string',
            'status' => 'integer|in:0,1',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }

}
