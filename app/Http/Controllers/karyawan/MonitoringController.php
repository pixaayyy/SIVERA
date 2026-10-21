<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_masuk', $request->tanggal);
        }

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

        return view('karyawan.monitoring', compact('barang'));
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

        // Load view khusus PDF dalam orientasi landscape
        $pdf = Pdf::loadView('karyawan.pdf_monitoring', compact('barang'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Monitoring_Barang_SIVERA.pdf');
    }

    public function exportExcel(Request $request)
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

        $view = view('karyawan.excel_monitoring', compact('barang'));

        return response($view, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="Laporan_Monitoring_Barang_SIVERA.xls"',
        ]);
    }
}