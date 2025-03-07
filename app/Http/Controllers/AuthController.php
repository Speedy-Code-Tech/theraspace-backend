<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
   
{
    // Validate OTP and email first
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|digits:6',
    ]);

    $email = $request->email;
    $storedOtp = Cache::get('otp_' . $email);

    if (!$storedOtp || $storedOtp != $request->otp) {
        return response()->json(['message' => 'Invalid or expired OTP'], 400);
    }

    // OTP verified, clear stored OTP and attempts
    Cache::forget('otp_' . $email);
    Cache::forget('otp_attempts_' . $email);

    // Check if user exists
    $existingUser = User::where('email', $email)->first();

    if ($existingUser) {
        // Update user status if they exist
        $existingUser->update(['status' => "verified"]);

        return response()->json([
            'message' => 'OTP verified successfully',
            'user' => $existingUser
        ]);
    }

    // If user doesn't exist, validate registration fields
    $request->validate([
        'fName' => 'required|string|max:255',
        'mName' => 'nullable|string|max:255',
        'lName' => 'required|string|max:255',
        'password' => 'required|string|min:8',
    ]);

    // Create new user
    $user = User::create([
        'fName' => $request->fName,
        'mName' => $request->mName,
        'lName' => $request->lName,
        'email' => $email, // Use validated email
        'password' => Hash::make($request->password),
        'status' => 'verified', // Mark as verified upon creation   
        'role'=>'user'
    ]);

    return response()->json([
        'message' => 'User registered successfullys',
        'user' => $user
    ], 201);
}


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if($user->status==='pending')
            return response()->json([
                'message' => 'Account is not yet verified',
                'user' => null
            ]);
            
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['msg' => "Wrong Credentials"], 404);   
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function edit(Request $request)
{
    $user = $request->user(); // Get authenticated user

    $request->validate([
        'fName' => 'nullable|string|max:255',
        'mName' => 'nullable|string|max:255',
        'lName' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role'=>'nullable'
    ]);

    // Update user fields if provided
    $user->update([
        'fName' => $request->fName ?? $user->fName,
        'mName' => $request->mName ?? $user->mName,
        'lName' => $request->lName ?? $user->lName,
        'email' => $request->email ?? $user->email,
        'password' => $request->password ? Hash::make($request->password) : $user->password,
        'role'=>$request->role
    ]);

    return response()->json([
        'message' => 'User details updated successfully',
        'user' => $user
    ]);
}
}