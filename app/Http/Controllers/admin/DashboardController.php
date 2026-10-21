<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\User;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $barangRusak = Barang::where('status_barang', 'Rusak')->count(); 
        $totalKaryawan = User::count(); 
        $kategoriData = Kategori::withCount('barang')->get();
        $kategoriStats = collect();
        
        if ($totalBarang > 0) {
            foreach ($kategoriData as $kategori) {
                $jumlah = $kategori->barang_count;
                $persentase = ($jumlah / $totalBarang) * 100;
                
                $kategoriStats->push((object)[
                    'nama_kategori' => $kategori->jenis_kategori, 
                    'persentase' => round($persentase, 1)
                ]);
            }
        }

        $barangRusakMasuk = Barang::where('status_barang', 'Rusak')->orderBy('tanggal_masuk', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBarang', 
            'barangRusak', 
            'totalKaryawan', 
            'kategoriStats', 
            'barangRusakMasuk'
        ));
    }
}