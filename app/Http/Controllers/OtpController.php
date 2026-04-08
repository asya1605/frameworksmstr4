<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtpController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($request->otp == $user->otp) {

            // hapus OTP setelah berhasil
            $user->otp = null;
            $user->save();

            if ($user->role->name == 'admin') {
                return redirect('/dashboard');
            }

            if ($user->role->name == 'vendor') {
                return redirect('/vendor/dashboard');
            }

            if ($user->role->name == 'customer') {
                return redirect('/home');
            }

            return redirect('/home');
        }

        return back()->with('error','OTP salah');
    }
}