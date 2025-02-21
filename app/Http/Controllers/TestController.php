<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
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
        $test = new Test();
        $test->name = $request->input('name');
        if ($test->save()) {
            return "Successful";
        } else {
            return "Error";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $test = Test::all();
        return $test;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
