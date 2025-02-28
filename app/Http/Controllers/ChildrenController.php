<?php

namespace App\Http\Controllers;

use App\Models\Children;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|max:255',
            'therapy_needs' => 'required|string|max:255',
        ]);

        $children = Children::create(
            [
                'user_id' => $request->user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'age' => $request->age,
                'therapy_needs' => $request->therapy_needs,
            ]
        );

        return response()->json([
            'message' => 'Children registered successfully',
            'user' => $children
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $children = Children::with('user')->find($id);
        if (!$children)
            return response()->json([
                'message' => 'Children Not Found',
                'children' => null
            ], 404);

        return response()->json([
            'message' => 'Children Found Successfully',
            'children' => $children
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Children $children)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {   
        $request->validate(['id'=>'required|integer|max:255']);
        $children = Children::find($request->id)->delete();
        if (!$children)
        return response()->json([
            'message' => 'Children Deleting Failed',
        ], 404);

    return response()->json([
        'message' => 'Children Deleted Successfully',
    ], 200);
    }
}
