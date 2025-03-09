<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inventory::with(['product', 'store', 'user', 'supplier'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
            'user_id' => 'required|exists:users,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'stock_added' => 'required|integer|min:1',
            'status' => 'required|integer|in:0,1',
        ]);
    
        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);
    
            $current_stock = $product->current_stock;
            $new_stock = $current_stock + $validated['stock_added'];
    
            // Create inventory record
            Inventory::create([
                'product_id' => $validated['product_id'],
                'store_id' => $validated['store_id'],
                'user_id' => $validated['user_id'],
                'supplier_id' => $validated['supplier_id'],
                'current_stock' => $current_stock,
                'stock_added' => $validated['stock_added'],
                'new_stock' => $new_stock,
                'status' => $validated['status'],
            ]);
    
            // Update product stock
            $product->update([
                'current_stock' => $new_stock,
                'total_stock' => $product->total_stock + $validated['stock_added'],
            ]);
        });
    
        return response()->json(['message' => 'Stock added successfully']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        return response()->json($inventory->load(['product', 'store', 'user', 'supplier']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'stock_added' => 'required|integer|min:1',
            'status' => 'required|integer|in:0,1',
        ]);
    
        DB::transaction(function () use ($validated, $inventory) {
            $product = Product::findOrFail($inventory->product_id);
    
            $new_stock = ($product->current_stock - $inventory->stock_added) + $validated['stock_added'];
    
            // Update inventory record
            $inventory->update([
                'current_stock' => $product->current_stock - $inventory->stock_added,
                'stock_added' => $validated['stock_added'],
                'new_stock' => $new_stock,
                'status' => $validated['status'],
            ]);
    
            // Update product stock
            $product->update([
                'current_stock' => $new_stock,
                'total_stock' => ($product->total_stock - $inventory->stock_added) + $validated['stock_added'],
            ]);
        });
    
        return response()->json(['message' => 'Inventory updated successfully']);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        DB::transaction(function () use ($inventory) {
            $product = Product::findOrFail($inventory->product_id);
    
            $product->update([
                'current_stock' => max(0, $product->current_stock - $inventory->stock_added),
                'total_stock' => max(0, $product->total_stock - $inventory->stock_added),
            ]);
    
            $inventory->delete();
        });
    
        return response()->json(['message' => 'Inventory record deleted successfully']);
    }
    
}
