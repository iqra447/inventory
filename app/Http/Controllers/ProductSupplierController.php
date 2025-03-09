<?php

namespace App\Http\Controllers;

use App\Models\ProductSupplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductSupplier::with(['product', 'supplier', 'registeredBy'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:New,Good,Damaged',
            'user_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);

            // Create product-supplier record
            ProductSupplier::create([
                'product_id' => $validated['product_id'],
                'supplier_id' => $validated['supplier_id'],
                'quantity' => $validated['quantity'],
                'num_in_stock' => $validated['quantity'],
                'total_stock' => $validated['quantity'],
                'condition' => $validated['condition'],
                'user_id' => $validated['user_id'],
            ]);

            // Update product stock
            $product->update([
                'total_stock' => $product->total_stock + $validated['quantity'],
                'current_stock' => $product->current_stock + $validated['quantity'],
            ]);
        });

        return response()->json(['message' => 'Product supplier registered successfully']);
    }


    /**
     * Display the specified resource.
     */
    public function show(ProductSupplier $productSupplier)
    {
        return response()->json($productSupplier->load(['product', 'supplier', 'registeredBy']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSupplier $productSupplier)
    {
        $validated = $request->validate([
            'quantity' => 'integer|min:1',
            'condition' => 'in:New,Good,Damaged',
        ]);

        DB::transaction(function () use ($validated, $productSupplier) {
            $product = Product::findOrFail($productSupplier->product_id);

            $new_stock = ($product->total_stock - $productSupplier->quantity) + $validated['quantity'];

            // Update product supplier record
            $productSupplier->update([
                'quantity' => $validated['quantity'],
                'num_in_stock' => $validated['quantity'],
                'total_stock' => $validated['quantity'],
                'condition' => $validated['condition'],
            ]);

            // Update product stock
            $product->update([
                'total_stock' => $new_stock,
                'current_stock' => $new_stock,
            ]);
        });

        return response()->json(['message' => 'Product supplier record updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSupplier $productSupplier)
    {
        DB::transaction(function () use ($productSupplier) {
            $product = Product::findOrFail($productSupplier->product_id);

            $product->update([
                'total_stock' => max(0, $product->total_stock - $productSupplier->quantity),
                'current_stock' => max(0, $product->current_stock - $productSupplier->quantity),
            ]);

            $productSupplier->delete();
        });

        return response()->json(['message' => 'Product supplier record deleted successfully']);
    }

}
