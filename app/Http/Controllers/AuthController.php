<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'karyawan') {
                return redirect()->route('karyawan.dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function lupaKatasandi()
    {
        return view('auth.lupakatasandi');
    }

    public function prosesLupaKatasandi(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::where('username', $request->username)->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Data ID Pengguna dan Email tidak ditemukan atau tidak cocok.'])->onlyInput('username', 'email');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('auth.email_reset', ['token' => $token, 'email' => $request->email], function($message) use($request) {
            $message->to($request->email);
            $message->subject('Atur Ulang Kata Sandi - SIVERA');
        });

        return back()->with('success', 'Terkirim, segera cek email anda.');
    }

    public function formResetKatasandi($token, Request $request)
    {
        return view('auth.resetkatasandi', ['token' => $token, 'email' => $request->email]);
    }

    public function prosesResetKatasandi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetToken) {
            return back()->withErrors(['email' => 'Token reset kata sandi tidak valid atau telah kedaluwarsa.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}