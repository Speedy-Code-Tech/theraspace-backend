<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $email = $request->email;
        $otp = rand(100000, 999999); // Generate 6-digit OTP
    
        // Get OTP attempt count for the user
        $attemptsKey = 'otp_attempts_' . $email;
        $otpKey = 'otp_' . $email;
        
        $attempts = Cache::get($attemptsKey, 0);
    
        if ($attempts >= 3) {
            return response()->json([
                'message' => 'You have exceeded the maximum number of OTP requests. Try again later.'
            ], 429);
        }
    
        // Store OTP in cache for 5 minutes
        Cache::put($otpKey, $otp, now()->addMinutes(5));
    
        // Increment OTP attempts, expires in 10 minutes
        Cache::put($attemptsKey, $attempts + 1, now()->addMinutes(10));
    
        // Prepare email body
        $subject = "Your OTP Code";
        $body = "<h2>Your OTP Code: <strong>{$otp}</strong></h2><p>This OTP is valid for 5 minutes.</p>";
    
        // Send email using MailHelper
        $emailSent = MailHelper::sendEmail($email, $subject, $body);
    
        if ($emailSent !== true) {
            return response()->json(['message' => 'Failed to send OTP. Please try again later.'], 500);
        }
    
        return response()->json(['message' => 'OTP sent successfully','otp'=>$otp]);
    }
    
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);
    
        $email = $request->email;
        $storedOtp = Cache::get('otp_' . $email);
    
        if (!$storedOtp || $storedOtp != $request->otp) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }
    
        // OTP verified, reset attempts
        Cache::forget('otp_' . $email);
        Cache::forget('otp_attempts_' . $email);
    
        return response()->json(['message' => 'OTP verified successfully']);
    }
}
