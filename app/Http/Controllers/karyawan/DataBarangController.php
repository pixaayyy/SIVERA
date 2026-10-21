<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class DataBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhere('ex_user', 'like', "%{$search}%"); 
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_barang', $request->kategori);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status_barang', $request->status);
        }

        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tanggal_masuk', $request->tanggal);
        }

        $barang = $query->get();
        $kategori = Kategori::all();

        return view('karyawan.databarang', compact('barang', 'kategori'));
    }
}