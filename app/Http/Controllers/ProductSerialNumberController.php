<?php

namespace App\Http\Controllers;

use App\Models\ProductSerialNumber;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductSerialNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductSerialNumber::with('product')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'serial_no' => 'required|string|unique:product_serial_numbers,serial_no',
            'color' => 'nullable|string',
        ]);

        ProductSerialNumber::create($validated);

        return response()->json(['message' => 'Serial number registered successfully']);
    }


    /**
     * Display the specified resource.
     */
    public function show(ProductSerialNumber $productSerialNumber)
    {
        return response()->json($productSerialNumber->load('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSerialNumber $productSerialNumber)
    {
        $validated = $request->validate([
            'color' => 'nullable|string',
        ]);
    
        $productSerialNumber->update($validated);
    
        return response()->json(['message' => 'Serial number updated successfully']);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSerialNumber $productSerialNumber)
    {
        $productSerialNumber->delete();

        return response()->json(['message' => 'Serial number deleted successfully']);
    }

}
