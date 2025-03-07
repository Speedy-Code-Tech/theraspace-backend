<?php

namespace App\Http\Controllers;

use App\Models\AdminSchedule;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AdminSchedule::first();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dates' => 'required|array', // Ensure dates is an array
        ]);

    
        AdminSchedule::truncate(); // Remove all previous records
    
        $dates = json_encode($request->dates); // Properly encode the array
    
        $schedule = AdminSchedule::create([
            'dates' => $dates,
        ]);
    
        return response()->json([
            'message' => 'Schedule created successfully',
            'schedule' => $schedule
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(AdminSchedule $adminSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminSchedule $adminSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminSchedule $adminSchedule)
    {
        //
    }
}
