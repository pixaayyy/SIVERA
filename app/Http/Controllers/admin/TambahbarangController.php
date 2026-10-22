<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UpdateInventarisNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TambahbarangController extends Controller
{
    public function index()
    {
        $kategori = DB::table('kategori')->get();
        return view('admin.tambahbarang', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_masuk'   => 'required|date',
            'kategori_barang' => 'required|integer|exists:kategori,id_kategori',
            'nama_barang'     => 'required|string|max:200', 
            'tipe'            => 'required|string|max:200', 
            'status_barang'   => 'required|in:Ready,Rusak', 
            'jumlah_unit'     => 'required|integer|min:1', 
            'nomor_asset'     => 'required|string|max:50|unique:barang,nomor_asset', 
            'ex_user'         => 'nullable|string|max:200',
            'departemen'      => 'nullable|string|max:200', 
        ], [
            'nomor_asset.unique' => 'Nomor asset ini sudah terdaftar. Silakan gunakan nomor aseet lain.'
        ]);

        DB::table('barang')->insert([
            'tanggal_masuk'   => $request->tanggal_masuk,
            'nama_barang'     => $request->nama_barang,
            'tipe'            => $request->tipe,
            'status_barang'   => $request->status_barang,
            'jumlah_unit'     => $request->jumlah_unit,
            'kategori_barang' => $request->kategori_barang,
            'ex_user'         => $request->ex_user,
            'departemen'      => $request->departemen,
            'nomor_asset'     => $request->nomor_asset
        ]);

        $users = User::where('id','!=', auth()->id())->get();
        $dataNotif = [
            'title' => 'Barang baru',
            'message' => auth()->user()->name . ' menambahkan barang baru: ' . $request->nama_barang,
            'url'=> route('karyawan.tambahbarang')
        ];
        Notification::send($users, new UpdateInventarisNotification($dataNotif));

        return redirect()->route('admin.tambahbarang')->with('success', 'Data barang berhasil ditambahkan');
    }
}