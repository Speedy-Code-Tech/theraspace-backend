<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function hello(){
        return response()->json(['name',"John JJEster Salen"]);
    } 
}
