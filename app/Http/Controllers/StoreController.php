<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Store::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|integer|in:0,1',
            'user_id' => 'required|exists:users,id',
        ]);
    
        return Store::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return response()->json($store);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|integer|in:0,1',
            'user_id' => 'required|exists:users,id',
        ]);
    
        $store->update($validated);
        return response()->json($store);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        $store->delete();
        return response()->json(['message' => 'Store deleted']);
    }
}
