<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
  
        $user = new User();
        $user->fName = $request->input('fName');
        $user->mName = $request->input('mName');
        $user->lName = $request->input('lName');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        if($user->save()){
            return "Data Save Successfully!";
        }else{
            return "Error Saving the data";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = User::all();
        return $user;
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
