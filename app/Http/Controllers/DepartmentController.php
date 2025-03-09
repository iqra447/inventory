<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Department::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'vote_code' => 'required|string|unique:departments',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id',
            'status' => 'required|integer|in:0,1',
            'user_id' => 'required|exists:users,id',
        ]);
    
        return Department::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'string',
            'vote_code' => 'string|unique:departments,vote_code,' . $department->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id',
            'status' => 'integer|in:0,1',
            'user_id' => 'exists:users,id',
        ]);
    
        $department->update($validated);
        return response()->json($department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(['message' => 'Department deleted']);
    }
}
