<?php

namespace App\Http\Controllers;

use App\Models\ProductItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductItem::with(['product', 'assignedTo', 'registeredBy'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'serial_no' => 'required|string|unique:product_items,serial_no',
            'condition' => 'required|in:New,Good,Damaged',
            'assigned_to' => 'nullable|exists:users,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|integer|in:0,1',
        ]);
    
        DB::transaction(function () use ($validated) {
            // Create product item
            ProductItem::create($validated);
    
            // Update product stock
            $product = Product::findOrFail($validated['product_id']);
            $product->update([
                'total_stock' => $product->total_stock + 1,
                'current_stock' => $product->current_stock + 1,
            ]);
        });
    
        return response()->json(['message' => 'Product item registered successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductItem $productItem)
    {
        return response()->json($productItem->load(['product', 'assignedTo', 'registeredBy']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductItem $productItem)
    {
        $validated = $request->validate([
            'condition' => 'in:New,Good,Damaged',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'integer|in:0,1',
        ]);

        $productItem->update($validated);

        return response()->json(['message' => 'Product item updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductItem $productItem)
    {
        DB::transaction(function () use ($productItem) {
            $product = Product::findOrFail($productItem->product_id);

            // Update product stock
            $product->update([
                'total_stock' => max(0, $product->total_stock - 1),
                'current_stock' => max(0, $product->current_stock - 1),
            ]);

            $productItem->delete();
        });

        return response()->json(['message' => 'Product item deleted successfully']);
    }

}
