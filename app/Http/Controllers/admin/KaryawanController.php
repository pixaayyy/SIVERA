<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('user')->latest()->get();

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'alpha_dash', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'karyawan'])],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama_karyawan'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            if ($validated['role'] === 'karyawan') {
                Karyawan::create([
                    'user_id' => $user->id,
                    'nama_karyawan' => $validated['nama_karyawan'],
                ]);
            }
        });

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->user()->delete();

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
