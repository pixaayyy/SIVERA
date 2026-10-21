<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($subq) use ($search) {
                      $subq->where('jenis_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $barang = $query->orderBy('tanggal_masuk', 'desc')->get();

        return view('admin.monitoring', compact('barang'));
    }

    public function exportPdf(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($subq) use ($search) {
                      $subq->where('jenis_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $barang = $query->orderBy('tanggal_masuk', 'desc')->get();

        $pdf = Pdf::loadView('admin.pdf_monitoring', compact('barang'))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Monitoring_Barang_SIVERA.pdf');
    }
}