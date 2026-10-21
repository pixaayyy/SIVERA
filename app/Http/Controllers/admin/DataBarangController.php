<?php

namespace App\Http\Controllers\Admin;

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

        $barang = $query->get();
        $kategori = Kategori::all();

        return view('admin.databarang', compact('barang', 'kategori'));
    }

    public function storeKategori(Request $request){
        $request->validate(['jenis_kategori' => 'required|string|max:225|unique:kategori,jenis_kategori',
        ],[
            'jenis_kategori.required'=> 'Nama kategori wajib diisi.',
            'jenis_kategori.unique'=> 'Kategori ini sudah ada',
        ]);

        Kategori::create([
            'jenis_kategori'=> $request->jenis_kategori
        ]);
        return redirect()->route('admin.tambahbarang')->with('success','Kategori baru berhasil ditambahkan ');
    }

    public function destroyKategori($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            
            $barangTerkait = Barang::where('kategori_barang', $id)->count();
            if ($barangTerkait > 0) {
                return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data barang.');
            }

            $kategori->delete();
            return back()->with('success', 'Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}