<?php

namespace App\Http\Controllers;

use App\Models\Theraphist;
use Illuminate\Http\Request;

class TheraphistConrtoller extends Controller
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
        ]);

      
        $Theraphists = Theraphist::create(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'specialization' => $request->specialization,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]
        );

        return response()->json([
            'message' => 'Theraphist registered successfully',
            'user' => $Theraphists
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Theraphist = Theraphist::find($id);
        if (!$Theraphist)
            return response()->json([
                'message' => 'Theraphist Not Found',
                'Theraphist' => null
            ], 404);

        return response()->json([
            'message' => 'Theraphist Found Successfully',
            'theraphist' => $Theraphist
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theraphist $Theraphist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {   
        $request->validate(['id'=>'required|integer|max:255']);
        $Theraphist = Theraphist::find($request->id)->delete();
        if (!$Theraphist)
        return response()->json([
            'message' => 'Theraphist Deleting Failed',
        ], 404);

    return response()->json([
        'message' => 'Theraphist Deleted Successfully',
    ], 200);
    }
}
