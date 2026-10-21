<?php 

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang; 
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $barangRusak = Barang::where('status_barang', 'Rusak')->count();
        $barangReady = Barang::where('status_barang', 'Ready')->count();

        $barangRusakMasuk = Barang::where('status_barang', 'Rusak')->orderBy('tanggal_masuk', 'desc')->limit(5)->get();

        $kategoriData = Kategori::withCount('barang')->get();
        $kategoriStats = collect();

        foreach ($kategoriData as $kategori) {
            $jumlah = $kategori->barang_count;
            $persentase = $totalBarang > 0 ? ($jumlah / $totalBarang) * 100 : 0;
            
            $kategoriStats->push((object)[
                'nama_kategori' => $kategori->jenis_kategori,
                'persentase' => round($persentase, 1)
            ]);
        }

        return view('karyawan.dashboard', compact(
            'totalBarang', 
            'barangRusak', 
            'barangReady', 
            'barangRusakMasuk', 
            'kategoriStats'
        ));
    }
}