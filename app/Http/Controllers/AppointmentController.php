<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Appointment::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'user_id' => 'required',
        ]);

        $appointment = Appointment::create($request->all());

        if ($appointment) {
            return response()->json([
                'message' => 'Appointment created successfully',
                'appointment' => $appointment
            ], 201);
        } else {
            return response()->json([
                'message' => 'Appointment creation failed',
                'appointment' => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return response()->json([
            'appointment' => $appointment->load('user')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'appointment_date' => 'sometimes|date',
            'appointment_time' => 'sometimes|date_format:H:i:s',
            'status' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $updated = $appointment->update($request->all());

        if ($updated) {
            return response()->json([
                'message' => 'Appointment updated successfully',
                'appointment' => $appointment
            ], 200);
        } else {
            return response()->json([
                'message' => 'Appointment update failed',
                'appointment' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $deleted = $appointment->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Appointment deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Appointment deletion failed'
            ], 500);
        }
    }

    public function status($id, Request $request)
    {
        $request->validate(['status' => 'required|string']);

        $status = Appointment::find($id);
        $status->status = $request->status;
        $status->notes = $request->notes;
        if ($status->save())
            return response()->json([
                'message' => 'Appointment updated  successfully'
            ], 200);
    }
}
