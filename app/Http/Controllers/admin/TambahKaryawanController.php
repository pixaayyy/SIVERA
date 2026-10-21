<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TambahKaryawanController extends Controller
{
    public function create()
    {
        return view('admin.tambahkaryawan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'email'         => 'required|email|unique:user,email',
            'username'      => 'required|string|max:255|unique:user,username',
            'password'      => 'required|string|min:6',
            'role'          => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'           => $request->nama_karyawan,
                'email'          => $request->email,
                'username'       => $request->username,
                'password'       => Hash::make($request->password), 
            ]);

            Karyawan::create([
                'user_id'       => $user->id,
                'nama_karyawan' => $request->nama_karyawan,
            ]);

            DB::commit();

            return redirect()->route('admin.datakaryawan')->with('success', 'Data Karyawan berhasil ditambahkan dan siap untuk login!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}