<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class NewPasswordController extends Controller
{
    // Menampilkan form input password baru
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    // Menyimpan password baru ke database tabel 'user'
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'token' => ['required']
        ]);

        // Cek token di database
        $tokenData = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Token reset tidak valid atau kedaluwarsa.']);
        }

        // Update password di tabel 'user'
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah! Silakan masuk menggunakan kata sandi baru.');
    }
}