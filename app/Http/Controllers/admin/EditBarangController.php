<?php

namespace App\Http\Controllers\Admin;

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
        
        return view('admin.editbarang', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'id_kategori'   => 'required',
            'nama_barang'   => 'required|string|max:255',
            'tipe'          => 'nullable|string|max:255',
            'ex_user'       => 'nullable|string|max:255',
            'nomor_asset'   => 'required|string|max:255',
            'status_barang' => 'required|in:Ready,Rusak'
        ]);

        $barang = Barang::findOrFail($id);
        
        $barang->update([
            'tanggal_masuk'   => $request->tanggal_masuk,
            'kategori_barang' => $request->id_kategori,
            'nama_barang'     => $request->nama_barang,
            'tipe'            => $request->tipe,
            'ex_user'         => $request->ex_user,
            'nomor_asset'     => $request->nomor_asset,
            'status_barang'   => $request->status_barang,
        ]);

        return redirect()->route('admin.databarang')->with('success', 'Data barang berhasil diperbarui!');
    }
}