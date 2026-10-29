<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang; 
use App\Models\Kategori; 

class EditBarangController extends Controller
{
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all(); 
        
        return view('karyawan.editbarang', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'id_kategori' => 'required',
            'nama_barang' => 'required|string|max:255',
            'tipe' => 'nullable|string|max:255',
            'ex_user' => 'nullable|string|max:255',
            'nomor_asset' => 'required|string|max:255',
            'status_barang' => 'required|in:Ready,Rusak'
        ]);

        $barang = Barang::findOrFail($id);

        $barang->tanggal_masuk      = $request->tanggal_masuk;
        $barang->kategori_barang    = $request->id_kategori;
        $barang->nama_barang        = $request->nama_barang;
        $barang->tipe               = $request->tipe;
        $barang->ex_user            = $request->ex_user;
        $barang->departemen         = $request->departemen;
        $barang->nomor_asset        = $request->nomor_asset;
        $barang->status_barang      = $request->status_barang;
        $barang->jumlah_unit        = $request->jumlah_unit;
        
        $barang->save();
        return redirect()->route('karyawan.databarang')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('karyawan.databarang')->with('success', 'Data barang berhasil dihapus!');
    }
}