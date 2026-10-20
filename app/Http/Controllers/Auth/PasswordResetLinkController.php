<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        // Cek apakah username dan email cocok di tabel 'user'
        $user = User::where('username', $request->username)
                    ->where('email', $request->email)
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Kombinasi ID Pengguna dan Email tidak ditemukan di sistem.',
            ])->withInput();
        }

        // Buat token reset password
        $token = Str::random(60);

        // Simpan ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => bcrypt($token),
                'created_at' => now()
            ]
        );

        // Link reset password
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

        // Format email menggunakan Tombol HTML
        $htmlMessage = '
        <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f4f6f9; border-radius: 10px;">
            <h2 style="color: #0284c7;">SIVERA - Pemulihan Kata Sandi</h2>
            <p>Halo <strong>' . $user->name . '</strong>,</p>
            <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun SIVERA Anda. Klik tombol di bawah ini untuk melanjutkan:</p>
            <div style="text-align: center; margin: 30px 0;">
                <a href="' . $resetUrl . '" style="background-color: #38b6ff; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;">Atur Ulang Kata Sandi</a>
            </div>
            <p style="color: #64748b; font-size: 12px;">Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini.</p>
        </div>
        ';

        // Kirim email dengan format HTML
        Mail::html($htmlMessage, function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Kata Sandi SIVERA');
        });

        // Mengembalikan pesan sukses sekaligus menyertakan link di layar (opsional untuk mempermudah testing)
        return back()->with('success', 'Link tautan pemulihan kata sandi telah dikirim ke email Anda.')
                     ->with('debug_link', $resetUrl);
    }
}