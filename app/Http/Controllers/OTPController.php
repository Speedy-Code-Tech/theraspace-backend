<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $otpCode = rand(100000, 999999);
        $subject = "Your OTP Code";
        $body = "<p>Your OTP code is: <strong>$otpCode</strong></p><p>This code will expire in 10 minutes.</p>";

        $sendMail = MailHelper::sendEmail($request->email, $subject, $body);

        if ($sendMail === true) {
            return response()->json(['message' => 'OTP sent successfully.']);
        } else {
            return response()->json(['error' => $sendMail], 500);
        }
    }
}
