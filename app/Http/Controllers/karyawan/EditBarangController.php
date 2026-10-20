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
        $barang->update($request->all());

        return redirect()->route('karyawan.databarang')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('karyawan.databarang')->with('success', 'Data barang berhasil dihapus!');
    }
}