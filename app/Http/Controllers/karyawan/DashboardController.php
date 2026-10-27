<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::sum('jumlah_unit');
        $barangReady = Barang::where('status_barang', 'Ready')->sum('jumlah_unit'); 
        $barangRusak = Barang::where('status_barang', 'Rusak')->sum('jumlah_unit'); 
        
        $kategoriData = Kategori::with('barang')->get();
        $kategoriStats = collect();
        
        foreach ($kategoriData as $kategori) {
            $barangKategori = Barang::where('kategori_barang', $kategori->id_kategori)->get();
            $totalUnitKat = $barangKategori->sum('jumlah_unit');
            
            $readyCount = $barangKategori->where('status_barang', 'Ready')->sum('jumlah_unit');
            $rusakCount = $barangKategori->where('status_barang', 'Rusak')->sum('jumlah_unit');
            
            $persentaseReady = $totalUnitKat > 0 ? ($readyCount / $totalUnitKat) * 100 : 0;
            $persentaseRusak = $totalUnitKat > 0 ? ($rusakCount / $totalUnitKat) * 100 : 0;
            
            $kategoriStats->push((object)[
                'nama_kategori' => $kategori->jenis_kategori, 
                'total_unit' => $totalUnitKat,
                'persentase_ready' => round($persentaseReady, 1),
                'persentase_rusak' => round($persentaseRusak, 1),
                'total_ready' => $readyCount,
                'total_rusak' => $rusakCount
            ]);
        }

        $rekapBarangMasuk = Barang::with('kategori')
            ->whereDate('tanggal_masuk', Carbon::today())
            ->select('kategori_barang', DB::raw('SUM(jumlah_unit) as total_unit'))
            ->groupBy('kategori_barang')
            ->get();

        return view('karyawan.dashboard', compact(
            'totalBarang', 
            'barangReady', 
            'barangRusak',  
            'kategoriStats', 
            'rekapBarangMasuk'
        ));
    }
}