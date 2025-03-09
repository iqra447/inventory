<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Assign::with(['user', 'product', 'asset', 'assignedBy', 'approvedBy', 'store', 'department'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'asset_id' => 'required|exists:product_items,id',
            'assigned_by' => 'required|exists:users,id',
            'assign_condition' => 'required|in:New,Good,Damaged',
            'total_items' => 'required|integer|min:1',
            'deadline' => 'nullable|date',
            'store_id' => 'required|exists:stores,id',
            'serial_no' => 'required|string|exists:product_items,serial_no',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:pending,approved,returned',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);
            $productItem = ProductItem::findOrFail($validated['asset_id']);

            // Ensure product is available
            if ($product->current_stock < $validated['total_items']) {
                throw new \Exception('Not enough stock available.');
            }

            // Create assignment
            Assign::create($validated);

            // Reduce stock
            $product->update([
                'current_stock' => $product->current_stock - $validated['total_items'],
            ]);

            // Mark product item as assigned
            $productItem->update([
                'status' => 0, // Mark as unavailable
            ]);
        });

        return response()->json(['message' => 'Product assigned successfully']);
    }


    /**
     * Display the specified resource.
     */
    public function show(Assign $assign)
    {
        return response()->json($assign->load(['user', 'product', 'asset', 'assignedBy', 'approvedBy', 'store', 'department']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assign $assign)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,returned',
            'approved_by' => 'required|exists:users,id',
            'approved_at' => 'required_if:status,approved|date',
        ]);
    
        $assign->update($validated);
    
        return response()->json(['message' => 'Assignment updated successfully']);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assign $assign)
    {
        DB::transaction(function () use ($assign) {
            $product = Product::findOrFail($assign->product_id);
            $productItem = ProductItem::findOrFail($assign->asset_id);
    
            // Restore stock
            $product->update([
                'current_stock' => $product->current_stock + $assign->total_items,
            ]);
    
            // Mark product item as available
            $productItem->update([
                'status' => 1, // Available
            ]);
    
            $assign->delete();
        });
    
        return response()->json(['message' => 'Assignment record deleted successfully']);
    }
    
}
