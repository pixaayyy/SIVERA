<?php 

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang; 
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $barangRusak = Barang::where('status_barang', 'Rusak')->count();
        $barangReady = Barang::where('status_barang', 'Ready')->count();

        $barangRusakMasuk = Barang::where('status_barang', 'Rusak')->orderBy('tanggal_masuk', 'desc')->limit(5)->get();

       $kategoriStats = DB::table('barang')
            ->join('kategori', 'barang.kategori_barang', '=', 'kategori.id_kategori')
            ->select('kategori.jenis_kategori as nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori.jenis_kategori')
            ->get()
            ->map(function ($item) use ($totalBarang) {
                $item->persentase = $totalBarang > 0 ? round(($item->total / $totalBarang) * 100) : 0;
                return $item;
            });

        return view('karyawan.dashboard', compact(
            'totalBarang', 
            'barangRusak', 
            'barangReady', 
            'barangRusakMasuk', 
            'kategoriStats'
        ));
    }
}
?>