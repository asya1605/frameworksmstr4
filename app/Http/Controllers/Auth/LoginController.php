<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect (tidak terlalu dipakai karena ada OTP)
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // hanya guest boleh akses login
        $this->middleware('guest')->except('logout');
    }

    /**
     * Setelah login berhasil
     * generate OTP lalu kirim email
     */
    protected function authenticated(Request $request, $user)
    {
        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        // redirect ke halaman input OTP
        return redirect()->route('otp.form');
    }
}