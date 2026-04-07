<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function verify(Request $request)
    {
        $user = Auth::user();

        if ($request->otp == $user->otp) {
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'OTP salah');
    }
}
