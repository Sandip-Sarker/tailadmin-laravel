<?php

namespace App\Helpers;

use App\Mail\EmailOTP;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Mail;

class SendOtp
{
    public static function send($user, string $mailType = 'forgot_password')
    {
        $otp = (new Otp)->generate($user->email,'numeric',6,60);

        $message = match ($mailType) {
            'verify' => 'Verify Your Email Address',
            'forgot_password' => 'Reset Your Password',
            default => 'OTP Verification',
        };

        Mail::to($user->email)->send(new EmailOTP($otp->token, $user, $message, $mailType));

        return $otp;
    }
}