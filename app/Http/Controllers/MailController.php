<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    // kirim email ke inbox
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->where('password', $request->password)->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
            ]);
            Mail::to($request->email)->send(new SendOtpMail($otp));
            session(['email' => $request->email]);
            return redirect()->route('otp');
        } else {
            return redirect()->back()->with('error', 'Email atau Password Salah');
        }
    }

    public function checkOtp(Request $request)
    {
        $user = User::where('otp', $request->otp)->where('email', session('email'))->first();
        if ($user) {
            $user->update([
                'otp' => '-',
            ]);
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Login Berhasil');
        } else {
            return redirect()->back()->with('error', 'OTP Salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
