<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Make;

class MakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Make::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:makes',
            'description' => 'nullable|string',
            'status' => 'required|integer|in:0,1',
        ]);
    
        return Make::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Make $make)
    {
        return response()->json($make);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Make $make)
    {
        $validated = $request->validate([
            'name' => 'string|unique:makes,name,' . $make->id,
            'description' => 'nullable|string',
            'status' => 'integer|in:0,1',
        ]);
    
        $make->update($validated);
        return response()->json($make);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Make $make)
    {
        $make->delete();
    return response()->json(['message' => 'Make deleted']);
    }
}
