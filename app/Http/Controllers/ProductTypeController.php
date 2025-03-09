<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductType::with('category')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:product_types',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|integer|in:0,1',
        ]);
    
        return ProductType::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductType $productType)
    {
        return response()->json($productType->load('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        $validated = $request->validate([
            'name' => 'string|unique:product_types,name,' . $productType->id,
            'description' => 'nullable|string',
            'category_id' => 'exists:categories,id',
            'status' => 'integer|in:0,1',
        ]);

        $productType->update($validated);
        return response()->json($productType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();
        return response()->json(['message' => 'Product Type deleted']);
    }
}
