<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditKaryawanController extends Controller
{
    public function edit($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('admin.editkaryawan', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        $user_id = $karyawan->user_id;

        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('user')->ignore($user_id)], // <-- ubah ke 'user'
            'username'      => ['required', 'string', 'max:255', Rule::unique('user')->ignore($user_id)], // <-- ubah ke 'user'
            'password'      => 'nullable|string|min:6', 
            'role'          => 'required|string|in:Admin,Karyawan'
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name'     => $request->nama_karyawan,
                'email'    => $request->email,
                'username' => $request->username,
                'role'     => $request->role,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            User::where('id', $user_id)->update($userData);

            $karyawan->update([
                'nama_karyawan' => $request->nama_karyawan,
            ]);

            DB::commit();
            return redirect()->route('admin.datakaryawan')->with('success', 'Data karyawan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $karyawan = Karyawan::findOrFail($id);
            $user_id = $karyawan->user_id;
            
            $karyawan->delete();
            User::where('id', $user_id)->delete();
            
            DB::commit();
            return redirect()->route('admin.datakaryawan')->with('success', 'Data karyawan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.datakaryawan')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}